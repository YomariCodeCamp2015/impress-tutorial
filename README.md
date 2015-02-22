# impress-tutorial
## How to get started

1. Clone this repo
```
git clone https://github.com/shubhajeet/impress-tutorial
```

2. **Database migration**
```
mysql -u $USER -p < db_migration.sql
```

3. *Edit default configuration*

```
mysql -u impress -p impress
```
```
UPDATE user SET Password=PASSWORD('YOURNEWPASSWORD') WHERE User='impress';
FLUSH PRIVILEGES;
exit;
```
```
emacs connect.php
```
4. Change Permission of tutorial

## Major source of error

### Permission
set permisssion of tutorial to be writable by others

```
chmod o+w tutorial
```
## Presetation

Presentation of this project is being created at gh-pages branch
http://YomariCodeCamp2015.github.io/impress-tutorial

## Try it out
(impress-tutorial at tutorial.sujit.email.np)[http://tutorial.sujit.email.np]