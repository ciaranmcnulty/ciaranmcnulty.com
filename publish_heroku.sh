./sculpin.phar generate --env=prod
git add output_prod
git commit -m "Publishing"
git push heroku master
