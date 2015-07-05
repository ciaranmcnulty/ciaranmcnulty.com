./bin/sculpin generate --env=prod
git branch -D master
git checkout -b master
git add -f output_prod
git commit -m "Publish site"
git filter-branch --subdirectory-filter output_prod/ -f
git push origin -f master
git push heroku -f master
