#!C:\Users\Reden Longcop\anaconda3\python.exe
print("Content-Type: text/html\n\n")
#!/usr/bin/env python
import sys
import pymysql
sys.path.append("c:\\users\\reden longcop\\anaconda3\\lib\\site-packages")

# coding: utf-8

# In[1]:


import pandas as pd


# In[2]:


artworks = pd.read_csv('sining.csv')

# In[5]:


artworks=artworks.dropna()

# In[10]:


artworks.loc[artworks['artTags'] == ''].count().iloc[0]


# In[11]:


artworks['artTags'] = artworks['artTags'].str.strip('[]').str.replace(' ','').str.replace("'",'')
artworks['artTags'] = artworks['artTags'].str.split(',')

# In[13]:


tagsList = []
for index, row in artworks.iterrows():
    tags = row["artTags"]
    
    for tag in tags:
        if tag not in tagsList:
            tagsList.append(tag)


# In[14]:


def binary(tag_list):
    binaryList = []
    
    for tag in tagsList:
        if tag in tag_list:
            binaryList.append(1)
        else:
            binaryList.append(0)
    
    return binaryList


# In[15]:


artworks['tags_bin'] = artworks['artTags'].apply(lambda x: binary(x))
artworks['tags_bin'].head(100)


# In[17]:


artistList=[]
for i in artworks['artistName']:
    if i not in artistList:
        artistList.append(i)


# In[18]:


def binary(artist_list):
    binaryList = []  
    for artist in artistList:
        if artist in artist_list:
            binaryList.append(1)
        else:
            binaryList.append(0)
    return binaryList


# In[19]:


artworks['artist_bin'] = artworks['artistName'].apply(lambda x: binary(x))


# In[20]:


artworks['artGenre'] = artworks['artGenre'].str.strip('[]').str.replace(' ','').str.replace("'",'')
artworks['artGenre'] = artworks['artGenre'].str.split(',')

# In[22]:


genreList = []
for index, row in artworks.iterrows():
    genres = row["artGenre"]
    
    for genre in genres:
        if genre not in genreList:
            genreList.append(genre)


# In[23]:


def binary(genre_list):
    binaryList = []
    
    for genre in genreList:
        if genre in genre_list:
            binaryList.append(1)
        else:
            binaryList.append(0)
    
    return binaryList


# In[24]:


artworks['genre_bin'] = artworks['artGenre'].apply(lambda x: binary(x))


# In[25]:


from scipy import spatial

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


# In[26]:


Similarity(1,50)



# In[28]:


new_id = list(range(0,artworks.shape[0]))
artworks['new_id']=new_id
artworks=artworks[['new_id','artTitle','artRate','artTags','artGenre','artistName','tags_bin','artist_bin','genre_bin','purchased']]


# In[29]:


import operator
dist=0
liked=[]
genre=[]
genre_prep=[]
def predict_score(name):
    output = ""
    #name = input('Enter art title: ')
    new_artworks = artworks[artworks['artTitle'].str.contains(name)].iloc[0].to_frame().T
    output += 'Selected Artworks: '+new_artworks.artTitle.values[0]
    output += 'Artwork Tags: '+str(new_artworks.artTags.values[0])
    output += 'Artwork Genre: '+str(new_artworks.artGenre.values[0])
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
    K = 10
    avgRating = 0
    neighbors = getNeighbors(new_artworks, K)
    output += '\nRecommended Artworks: \n'
    for neighbor in neighbors:
        #if artworks.iloc[]
        #genre_prep
        liked.append(artworks.iloc[neighbor[0]][9])
        avgRating = int(avgRating)+int(artworks.iloc[neighbor[0]][2])  
        output += artworks.iloc[neighbor[0]][1].replace("-"," ")+" | Art Tags: "+str(artworks.iloc[neighbor[0]][3]).strip('[]').replace(' ','')+" | Rating: "+str(artworks.iloc[neighbor[0]][2])+str(dist)+" | Like: "+str(artworks.iloc[neighbor[0]][9])
    output += '\n'
    avgRating = avgRating/K
    #output += 'The predicted rating for is:'+ new_artworks['artTitle'].values[0]+" "+str(avgRating)
    #output += 'The actual rating for is' + new_artworks['artTitle'].values[0]+" "+new_artworks['artRate']
    #output += liked
    
    return output

# In[]:
connection = pymysql.connect(host="localhost", user="root", passwd="", database="knn")
cursor = connection.cursor()

sql_statement= "Select artTitle from input;"
cursor.execute(sql_statement)
inputs = cursor.fetchall()

for row in inputs:
    artTitle = row
    
artTitle = artTitle[0]

print(artTitle)

output = predict_score(artTitle)

# In[]:


