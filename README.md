# 🤖 CBER Deploy-bot 🤖

A cold, unfeeling, mechanical monster, hell-bent on overseeing the automatic deployment of the 
websites developed by the Ball State University Center for Business and Economic Research. 

#### Steps for setting up auto-deployment for a site
- Log in as as okbvtfr user
- Clone site twice (production and staging)  
	`git clone -b master (repo) (dirname)`  
	`git clone -b development (repo) (dirname_staging)`
- Upload `.env.production` and rename to `.env`
- Create staging.(domain) subdirectory pointed at (dirname_staging)
- Add site to deploy app's sites.php
- Set up webhook in GitHub  
    `https://deploy.cberdata.org/`
- Optional: Protect master branch in GitHub
