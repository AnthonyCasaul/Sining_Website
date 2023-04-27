#!C:\Users\Reden Longcop\anaconda3\python.exe
print("Content-Type: text/html\n\n")
#!/usr/bin/env python
import sys
import pymysql
sys.path.append("c:\\users\\reden longcop\\anaconda3\\lib\\site-packages")

connection = pymysql.connect(host="localhost", user="root", passwd="", database="knn")
cursor = connection.cursor()

sql_statement= "Select artTitle from input;"
cursor.execute(sql_statement)
inputs = cursor.fetchall()

for row in inputs:
    artTitle = row
    
artTitle = artTitle[0]

print(artTitle)