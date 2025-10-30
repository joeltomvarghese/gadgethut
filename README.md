GadgetHut - M-Commerce Project Guide (v2 with Cart)

This guide provides all steps to get your PHP/MySQL application running locally with XAMPP and deployed on an AWS EC2 instance.

This version includes a full shopping cart, product details page, and checkout flow.

Project File Structure

Your gadgethut folder should contain the following files:

header.php (NEW - Handles Nav, Session, and opening HTML)

footer.php (NEW - Handles Footer and closing HTML)

index.php (UPDATED - Main product grid)

product.php (NEW - Shows product details)

cart.php (NEW - Shows the shopping cart)

cart-logic.php (NEW - Handles Add/Update/Remove from cart)

checkout.php (NEW - Simulated checkout page)

login.php (UPDATED - Uses header/footer)

register.php (UPDATED - Uses header/footer)

logout.php (No change)

db_connect.php (No change)

database.sql (No change - cart is stored in session)

style.css (UPDATED - New styles for cart, product page, etc.)

README.md (This file)

PHASE 1: Local Setup (XAMPP)

Install XAMPP: Download and install XAMPP from https://www.apachefriends.org/.

Start XAMPP: Open the XAMPP Control Panel and start the Apache and MySQL services.

Create Project Folder:

Go to your XAMPP installation directory (e.g., C:\xampp).

Open the htdocs folder.

Create a new folder named gadgethut.

Add Code: Place all the files listed above into this gadgethut folder.

PHASE 2: Database Setup (phpMyAdmin)

(This is the same as before. If you've already done this, you don't need to do it again.)

Open phpMyAdmin: In your browser, go to http://localhost/phpmyadmin/.

Create Database:

Click on the Databases tab.

In the "Create database" field, type gadgethut and click Create.

Import SQL File:

Click on the gadgethut database you just created (in the left-hand sidebar).

Click on the Import tab.

Click Choose File and select the database.sql file.

Scroll down and click Go.

You should see products and users tables.

Test Locally:

Open your browser and go to http://localhost/gadgethut/.

You should see the homepage.

Test the new features:

Click a product to see the product.php page.

Click "Add to Cart".

Click the cart icon in the nav to go to cart.php.

Try logging in and clicking "Proceed to Checkout".

PHASE 3: Version Control (GitHub)

Check Status: Open a terminal in your gadgethut folder and run git status. You will see all the new and modified files.

Add and Commit Changes:

git add .
git commit -m "Feat: Add full shopping cart and product details"


Push to GitHub:

git push origin main


PHASE 4: AWS EC2 Deployment

(If you already have your server running, you just need to update the code.)

Connect to your EC2 Instance:

ssh -i "gadgethut-key.pem" ubuntu@YOUR_PUBLIC_IP_ADDRESS


Update Your Code:

Navigate to your web directory:

cd /var/www/html


Pull the latest changes from your GitHub repository:

sudo git pull origin main


Set Permissions: Git might change file ownership. Re-apply permissions to be safe:

sudo chown -R www-data:www-data /var/www/html


IMPORTANT: Your db_connect.php on the server should not be overwritten. git pull might complain about this. If it does, you can stash the change:

sudo git stash         # Temporarily save your local db_connect.php
sudo git pull origin main  # Pull all the new files
sudo git stash pop       # Re-apply your server's db_connect.php

# If you have conflicts, you may need to manually fix db_connect.php again:
# sudo nano db_connect.php
# (Make sure it has the AWS 'gadgethut_user' and password)


Test Deployed Site:

Open your browser and go to your EC2 public IP: http://YOUR_PUBLIC_IP_ADDRESS

Test all the new cart and product features to ensure they work live.