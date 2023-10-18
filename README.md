# ScrapeSplorer

Web app to visualize results from different scrapers.

## 🚀 Technology

* 🥑 ArangoDb - storage backend
* 🐍 Python - most scrapers
* 👥 NSQ - transporting data from scrapers to the database
* 𝄞 Symfony - web development framework

## 📝 TODOs

* Create a view for a given reference number, in particular to show context of canceled auctions
* derived list: Zwangsversteigerung by clustering around reference number (Aktenzeichen)
* Basic filtering and sorting

## ✅ Done

* List entries from ZvgScraper
* integrate Bootstrap
* Home page that shows scraper counts
* Setup dev environment: dump remote database and restore it locally
 
## 🔄 Follow Up

* `arangodump` does not support client side certificates: https://github.com/arangodb/arangodb/issues/19985

## 🪒 Scraper

| Scraper        | Scraper Status | Web App Support |
|----------------|----------------|-----------------|
| zvg-portal.de  | Running        | Development     |
| KVNO Arztsuche | Testing        | -               |
