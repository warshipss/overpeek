#!/usr/bin/env bash

git commit -a
git push
git checkout master
git merge develop --no-ff
git push
git checkout develop
