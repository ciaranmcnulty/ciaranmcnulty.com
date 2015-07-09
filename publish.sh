if [ "$#" -ne 1 ]; then
    echo "Provide a branch name only"
    exit;
fi
./bin/sculpin generate --env=prod
git branch -D $1
git checkout -b $1
git add -f output_prod
git commit -m "Publish site"
git filter-branch --subdirectory-filter output_prod/ -f

