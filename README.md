# ScrapeSplorer

Web app to visualize results from different scrapers.

## 🚀 Technology

* 🥑 ArangoDb - storage backend
* 🐍 Python - most scrapers
* 👥 NSQ - transporting data from scrapers to the database
* 𝄞 Symfony - web development framework

## 📝 TODOs

* integrate Bootstrap
* List entries from ZvgScraper
* Basic filtering and sorting
* Create a view for a given `zvg_id`, in particular to show context of canceled auctions

## ✅ Done

* Setup dev environment: dump remote database and restore it locally
* Home page that shows scraper counts

## 🔄 Follow Up

* `arangodump` does not support client side certificates: https://github.com/arangodb/arangodb/issues/19985

## 🪒 Scraper

| Scraper        | Scraper Status | Web App Support |
|----------------|----------------|-----------------|
| zvg-portal.de  | Running        | Development     |
| KVNO Arztsuche | Running        | -               |
