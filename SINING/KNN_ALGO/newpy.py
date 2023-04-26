#!C:\Users\hp\AppData\Local\Programs\Python\Python311\python.exe
print("Content-Type: text/php\n\n")
import warnings

import sys
sys.path.append("C:\\Users\\hp\\AppData\\Local\\Programs\\Python\\Python311\\Lib\\site-packages")
import pymysql
import json
import codecs
import io
import base64
import pandas as pd
from scipy import spatial
import operator

warnings.filterwarnings("ignore")
#print("<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css' rel='stylesheet' >")
#print("<center>")
#print("<title>KNN ART RECOMMENDATION</title>")
#print("<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js'></script>")

connection = pymysql.connect(host="localhost", user="root", passwd="", database="jcra-sining")
cursor = connection.cursor()

sql = "SELECT * FROM `sining_artworks1`"
df = pd.read_sql(sql, connection)
artworks = pd.DataFrame(df.to_dict('list'))

#artworks = pd.read_csv('sining.csv')

artworks=artworks.dropna()
artworks.loc[artworks['artTags'] == ''].count().iloc[0]

artworks['artTags'] = artworks['artTags'].str.strip('[]').str.replace(' ','').str.replace("'",'')
artworks['artTags'] = artworks['artTags'].str.split(',')

tagsList = []
for index, row in artworks.iterrows():
    tags = row["artTags"]

    for tag in tags:
        if tag not in tagsList:
            tagsList.append(tag)


def binary(tag_list):
    binaryList = []

    for tag in tagsList:
        if tag in tag_list:
            binaryList.append(1)
        else:
            binaryList.append(0)

    return binaryList

artworks['tags_bin'] = artworks['artTags'].apply(lambda x: binary(x))

artistList=[]
for i in artworks['artistName']:
    if i not in artistList:
        artistList.append(i)

def binary(artist_list):
    binaryList = []
    for artist in artistList:
        if artist in artist_list:
            binaryList.append(1)
        else:
            binaryList.append(0)
    return binaryList
artworks['artist_bin'] = artworks['artistName'].apply(lambda x: binary(x))

artworks['artGenre'] = artworks['artGenre'].str.strip('[]').str.replace(' ','').str.replace("'",'')
artworks['artGenre'] = artworks['artGenre'].str.split(',')


genreList = []
for index, row in artworks.iterrows():
    genres = row["artGenre"]
    
    for genre in genres:
        if genre not in genreList:
            genreList.append(genre)



def binary(genre_list):
    binaryList = []
    
    for genre in genreList:
        if genre in genre_list:
            binaryList.append(1)
        else:
            binaryList.append(0)
    
    return binaryList

artworks['genre_bin'] = artworks['artGenre'].apply(lambda x: binary(x))

def Similarity(artworkId1, artworkId2):
    a = artworks.iloc[artworkId1]
    b = artworks.iloc[artworkId2]
    
    tagsA = a['tags_bin']
    tagsB = b['tags_bin']
    
    tagsDistance = spatial.distance.cosine(tagsA, tagsB)
    
    artistA = a['artist_bin']
    artistB = b['artist_bin']
    artistDistance = spatial.distance.cosine(artistA, artistB)
    
    genreA = a['genre_bin']
    genreB = b['genre_bin']
    genreDistance = spatial.distance.cosine(genreA, genreB)
    return tagsDistance + artistDistance + genreDistance

new_id = list(range(0,artworks.shape[0]))
artworks['new_id']=new_id
artworks=artworks[['new_id','artTitle','artRate','artTags','artGenre','artistName','tags_bin','artist_bin','genre_bin','purchased','artImage','artId','artPrice']]

dist=0
liked=[]
genre=[]
genre_prep=[]
def predict_score(name):
    #output = ""
    #name = input('Enter art title: ')
    output=""
    name = name[0:5]
    new_artworks = artworks[artworks['artTitle'].str.contains(name)].iloc[0].to_frame().T
    #output = 'Selected Artworks: ' + new_artworks.artTitle.values[0] + "\n"
    output += "{\"Recommended\":[\n"


    #output += 'Artwork Tags: '+str(new_artworks.artTags.values[0])+"<br>"
    #output += 'Artwork Genre: '+str(new_artworks.artGenre.values[0])+"<br>"
    def getNeighbors(baseArt, K):
        distances = []
    
        for index, artwork in artworks.iterrows():
            if artwork['new_id'] != baseArt['new_id'].values[0]:
                dist = Similarity(baseArt['new_id'].values[0], artwork['new_id'])
                distances.append((artwork['new_id'], dist))
    
        distances.sort(key=operator.itemgetter(1))
        neighbors = []

        for x in range(K):
            neighbors.append(distances[x])
        return neighbors
    
    genre.append(new_artworks['genre_bin'].values[0])
    K = 46
    avgRating = 0
    neighbors = getNeighbors(new_artworks, K)
    #output += '\nRecommended Artworks: \n'+"<br>"
    last = neighbors[-1]
    for neighbor in neighbors:
        #if artworks.iloc[]
        #genre_prep
        liked.append(artworks.iloc[neighbor[0]][9])
        avgRating = int(avgRating)+int(artworks.iloc[neighbor[0]][2])  
        
        #output += "<img src="+artworks.iloc[neighbor[0]][10]+" width='200px' height='250px'/>"
        #output += "<p>"+artworks.iloc[neighbor[0]][1].replace("-"," ")+"<br> | Art Tags: "+str(artworks.iloc[neighbor[0]][3]).strip('[]').replace(' ','')+" | Rating: "+str(artworks.iloc[neighbor[0]][2])+str(dist)+"</p>"
        output += "{\"image_url\":\""+artworks.iloc[neighbor[0]][10]+"\",\n\"name\":\""+artworks.iloc[neighbor[0]][1].replace("-"," ")+"\",\n\"tags\":\""+str(artworks.iloc[neighbor[0]][3]).strip('[]').replace(' ','').replace('\'',"")+"\",\n\"id\":\""+str(artworks.iloc[neighbor[0]][11])+"\",\n\"price\":\""+str(artworks.iloc[neighbor[0]][12])+"\"}\n"
        if neighbor != last:
            output += ","

    #output += '\n'
    output +="]}"
    avgRating = avgRating/K

    return output

sql_statement= "Select artId from input;"
cursor.execute(sql_statement)
inputs = cursor.fetchall()

for row in inputs:
    artId = row
    
artId = artId[0]

sql_statement = "Select artTitle from sining_artworks where artId=\""+str(artId)+"\";"
cursor.execute(sql_statement)
inputs = cursor.fetchall()

for row in inputs:
    artTitle = row

artTitle = artTitle[0]

if "-" in artTitle:
    temp = artTitle.split("-")
    artTitle = temp[0]
#print (artTitle)
output = predict_score(artTitle)
print(output)