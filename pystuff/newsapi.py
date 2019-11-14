import requests
import json
import pandas

headers = {'Authorization': 'fdfcb0b526b24fa788a2891caaeacd3b'}

top_headlines_url = 'https://newsapi.org/v2/top-headlines'
	
headlines_payload = {'country': 'gb', 'sortBy': 'popularity', 'pageSize': 5}

news = requests.get(url=top_headlines_url, headers=headers, params=headlines_payload)

news_output = json.dumps(news.json())
news_dict = json.loads(news_output)

news_title = news_dict['articles']

results = []

for ar in news_title: 
	results.append(ar["title"]) 

print(results)          

