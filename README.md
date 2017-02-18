#Magento Project

Welcome
---

Install

Permission:

```
HTTPDUSER='www-data' &&
sudo chown -R `whoami`:"$HTTPDUSER" . &&
find . -type d -exec chmod 775 {} \; && find . -type f -exec chmod 664 {} \;
chmod o+w -R app/etc media var
```