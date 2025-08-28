# link-in-bio-wordpress-plugin
It makes a landing page for "link in bio" link on Instagram and other social media. You can attach the social media post image to posts so when someone visits the landing page through the link in the bio they can find the post based on the image.

I use this exact code for this Instagram: https://instagram.com/akosirkal

And the landing page it generates is this: https://akosirkal.blog/link-in-bio/

## How to install
Put the PHP file and CSS folder and its contents in a folder named "link_in_bio_grid" and copy that in the wp-content/plugins forlder on your server. Or zip it and upload it in WordPress's plugin manager. After this you have to activate it in the plugin page. This plugin has no settings or any admin page, you just have to make a new page and use the [image_grid] short code, to render the grid. It also puts a meta box in the post editor where you can upload your image for given post. 

## Warning
As this is a plugin I made for my own use (linked above) I do not and can not garantee it will work for you. One thing that could be a problem is the short code's name. I am sure there are many plugins that use the same short code for their ideas. So you might want to change it in code. Just replace the word image_grid to something else everywhere and reinstall the plugin.
