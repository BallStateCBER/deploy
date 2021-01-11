# 🤖 CBER Deploy-bot 🤖

A cold, unfeeling, mechanical monster, hell-bent on overseeing the automatic deployment of the 
websites developed by the Ball State University Center for Business and Economic Research. 

#### Steps for setting up auto-deployment for a site
- Log in as as `okbvtfr` user
- Clone site twice (production and staging)  
	`git clone -b master (repo) (dirname)`  
	`git clone -b development (repo) (dirname_staging)`
- Run `composer install --no-dev` in both directories
- Run `npm install` in both directories (if needed)  
  **Note:** If errors are generated due to reaching memory limit, try running this command as `root` user and then running
  `chown -R okbvtfr:okbvtfr node_modules` to give ownership back to `okbvtfr`
- Upload `.env.production` and rename to `.env`
- Create staging.(domain) subdomain pointed at (dirname_staging)
- Add site to deploy app's sites.php
- Set up webhook in GitHub  
    `https://deploy.cberdata.org/`
- Optional: Protect master branch in GitHub
