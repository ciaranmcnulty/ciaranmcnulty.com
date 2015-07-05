./sculpin generate --env=prod
git add output_dev
git commit -m "Publishing"
git push heroku master
