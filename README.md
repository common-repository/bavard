# How to publish Bavard wordpress plugin

1. ## Change directories locally to subversion directory.

   `cd subversion`

2. ## Checkout the plugin

   You will be prompted for the username and password that you used to register with WordPress. It will be added locally if they already do not exist.

   `svn co http://svn.wp-plugins.org/bavard`

   Note: Any folders or files you add manually within your trunk directory must be registered via Subversion.

   Example of adding your icon.svg file to the assets directory:

   `svn add tweetthis-shortcode/assets/icon.svg`

   Or deleting:

   `svn rm tweetthis-shortcode/assets/icon.svg`

3. ## Copy the repo contents into subersion trunk folder. 

```
cp -r chatbot-wp-plugin/ subversion/bavard/trunk/
cd subversion
```

4. ## Add plugin files to trunk and new tag directory

   You should add the changes in trunk directory where the development version plugin code should live.

   Once you’ve added all of directories and files within the trunk directory, it's time to add them to a new tag directory with the new version as the folder name.

   `svn copy trunk/* tags/1.0.0`

5. ## Check in the plugin.

   `svn ci -m "Version 1.0.0"`

   All files are transferred to the repository, and a successful message is provided if you’re plugin is checked in. Additionally, you’ll also receive an email notification that details the check-in. It even provides a color-coded detailed copy of your edits, adds and removals.
