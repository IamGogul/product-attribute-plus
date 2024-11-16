=== Product Attribute Plus ===
Contributors:iamgogul
Tags:Swatches, Product Attributes, Product Attributes Plus, Color + Image + Label Swatches, Swatch Shapes
Requires PHP: 7.0
Requires at least:6.4
Tested up to:6.7
Stable tag:1.0.0
License:GPLv2 or later
License URI:http://www.gnu.org/licenses/old-licenses/gpl-2.0.html

Product Attribute Plus enhances WooCommerce product attributes with Color, Label, and Image Swatches.

== Description ==
Product Attribute Plus is a free WooCommerce plugin that expands product attribute options. It ads Color, Label, and Image Swatches alongside the standard dropdown menu.

== How to install Product Attribute Plus Plugin ==
1.Login to Your WordPress Dashboard
2.Navigate to the Plugins Section
3.Choose "Add New"
4.Search for the Plugin: ( In the "Search plugins" box, type "Product Attribute Plus" )
5.Select the "Product Attribute Plus" Plugin & Activate it.

== Installing a WordPress plugin via FTP (File Transfer Protocol) involves uploading the plugin files to your server manually. ==
1.Download the Product Attribute Plus extension for WooCommerce Plugin
2.Unzip the downloaded file. You'll typically get a folder containing all the plugin files.
3.Use an FTP client like FileZilla to connect to your server.
4.Once connected, navigate to the /wp-content/plugins/ directory in your WordPress installation on the server.
5.From your local machine, locate the folder extracted in step 2. Drag this folder into the /wp-content/plugins/ directory on your server.
6.Allow FileZilla or your FTP client to complete the upload. This might take a few moments, depending on the plugin's size and your internet speed.
7.Once the upload is complete, go to your WordPress dashboard. Navigate to the "Plugins" section. You should see the plugin you just uploaded listed there. Click "Activate" to activate the plugin.

== How to use ==
1.First, install and activate the [WooCommerce Plugin.](https://wordpress.org/plugins/woocommerce/) This plugin is necessary to use Product Attribute Plus Plugin.
2.Next, install & activate the [Product Attribute Plus](https://wordpress.org/plugins/product-attribute-plus)
3.Once both plugins are activated, go to <strong>WooCommerce > Settings > Swatches</strong> to set the default options and configurations for single variable product page.

== WooCommerce Themes ==
Product Attribute Plus works with any theme, including:

* Astra
* Hello Elementor
* OceanWP
* Storefront
* WordPress Default themes

== Source Files and Compression Details ==
This plugin includes compressed JavaScript and CSS files for optimal performance. The uncompressed source files and build instructions are provided to ensure transparency:

- **Uncompressed JavaScript Files**:
  - `/product-attribute-plus/src/js/admin` – JavaScript files for the admin area.
  - `/product-attribute-plus/src/js/public` – JavaScript files for the public-facing area.

- **Uncompressed SCSS Files**:
  - `/product-attribute-plus/src/scss/admin` – SCSS files for the admin area.
  - `/product-attribute-plus/src/scss/public` – SCSS files for the public area.

**Build Instructions**:
All necessary libraries and steps to build the files are included in the `package.json` file. To compile and compress the source files, run the appropriate build commands outlined in the `package.json`.

For more details on setting up the build process, please refer to the `package.json` file located in the root of the plugin directory. Here are the main commands to use:

- `npm run scss:admin:min` – Builds a production (compressed) version of the CSS file for the admin area.
- `npm run scss:public:min` – Builds a production (compressed) version of the CSS file for the public-facing area.
- `npm run js:dev` – Creates both uncompressed and development versions of the JavaScript files.
- `npm run js:prod` – Builds production (compressed) versions of the JavaScript files.

== Changelog ==
= 1.0.0 =
*   Initial release