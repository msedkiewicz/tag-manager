# Marketing Tag Manager by MSedkiewicz

Simple WP plugin for adding script tags to custom post type.

# For developers

## Approach

Main objective while writing this plugin was to separate admin environment (for adding / editing tag) and other users environment for adding tag to posts / pages.

## What was achieved
1. Plugin code is executed in footer
2. Options page that allow to add plugin is available only for admin

## Further improvements

1. Saving tags in custom post type (probably it would be more beneficial to keep whole logic in custom post type alnd play with current_user_can() function more - https://developer.wordpress.org/reference/functions/current_user_can/)
2. Add logic for chosing which posts / pages should display chosen tags (https://developer.wordpress.org/plugins/metadata/custom-meta-boxes/)
3. Add sanitization (for security reasons; this would require research on most popular tags syntax and maybe additional field for admin to add new syntax to allowed list)
4. Allow using <script> tag in content (currently script tag is added in plugin and this may cause some issues in case ie. of Google analytics - if user chooses to add GA tag in footer, despite recommendations, it would require adding 2 tags and making sure they fire in proper order)
