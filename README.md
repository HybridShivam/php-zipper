# Zipper
Configuration for apache on Ubuntu.
[ Assuming the project is at `DocumentRoot/zipper` ]

Install `php-zip mod` and enable it:
```
sudo apt-get install php-zip
sudo phpenmod zip
sudo service apache2 restart
```
Make sure all files are owned by the Apache group and user. In Ubuntu it is the `www-data` group and user:
```
sudo chown -R www-data:www-data /var/www/html/zipper/userUploads/
```
Next enable all members of the `www-data` group to read and write `userUploads/` files:
```
sudo chmod -R g+rw /var/www/html/zipper/userUploads/
```

---

# CleanScript CronJob

`vi /home/ubuntu/scripts/cleanUpOldUploads.sh`
```
#!/bin/sh
touch log.txt;
whoami >> log.txt;
find /var/www/html/zipper/userUploads -type f ! -name '.doNotDeleteMe' -mmin +1440 -exec rm -r {} \;
find /var/www/html/zipper/userUploads -type d -empty -delete;
echo " Time: $(date -Iseconds) : Run Again" >> log.txt;
```
`chmod +x /home/ubuntu/scripts/cleanUpOldUploads.sh`

`crontab -e`

Add this line at the end:
```
0 0 * * * /home/ubuntu/scripts/cleanUpOldUploads.sh
```