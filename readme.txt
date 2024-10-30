=== CBX Accounting & Bookkeeping ===
Contributors: manchumahara,codeboxr
Tags: accounting,bookkeeping,income,expense
Requires at least: 3.5
Tested up to: 5.5
Stable tag: 1.3.14
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Accounting/bookkeeping solution SME business inside WordPress

== Description ==

CBX Accounting plugin gives easy and quick solution for book keeping for small business inside wordpress to keep the income and expense log. This plugin is created thinking for people who doesn't understand accounting but need help to track income and expense. This is not double entry accounting system but it's a tracking system for income and expense and helps to display logs and statements. From the very beginning we tried to keep the plugin as simple as possible and still don't add complex features so that it's easy for non accountant people.

### CBX Accounting & Bookkeeping by [Codeboxr](https://codeboxr.com/product/cbx-accounting/)

>[Learn More](https://codeboxr.com/product/cbx-accounting/) | [Documentation](https://codeboxr.com/documentation-for-cbx-accounting/) | [Free Support](https://wordpress.org/support/plugin/cbxwpsimpleaccounting/) | [Pro Support](https://codeboxr.com/contact-us/)


**If you think any necessary feature is missing contact with us, we will add in new release. Best way to check the feature is install the free core version in any dev site and explore**

= Core Plugin Features =


**CBX Accounting: Main Features**

* Overview Dashboard
* Plugin Setting with multiple tabs and 100s of setting fields
* Log Manager
* Income & Expense Manage
* Income & Expense Category
* Log Add, Edit, Delete
* Vendor & Clients(Free addon)
* Bank Accounts & Cash Account Manager
* Statement Generate(Pro Features)
* WooCommerce Integrations(Pro features)
* Frontend Account with all backend features
* Export Logs in PDF and Excel formats
* Role and Capability based access control for all urls and views


**CBX Accounting: Overview Dashboard**

* Quick summary of year graph: Shows Current year by default
* Quick summary of year graph: Next/Prev Year explore
* Quick summary of month graph: Shows Current month by default
* Quick summary of month graph: Next/Prev month explore
* Pie Diagram of Latest Income and Expense by Category(By Month, connected with next prev of month explore)
* Quick Summary(Including Tax)(By Month, connected with next prev of month explore)
* Current Month Latest Income(Showing latest 20 entries)
* Current Month Latest Expense(Showing latest 20 entries)

**CBX Accounting: Log Manager**

* List of all logs/entries of income and expense in tabular format.
* Search log: By Income Category
* Search log: By Expense Category
* Search log: By Bank Accounts
* Search log: By Date Range
* Search log: By Vendors and Clients(Depends on Free addon)
* Export Option: Export by PDF
* Export Option: Export by Excel(XLS, XLSX, ODS)
* Listing Bulk Option: Delete single or multiple logs/entries
* Listing Headings: ID, Title, Amount, Type, Category, Account, Vendor & Client(V&C), Added By, Modified By
* Listing Headings(cont.): Added Date, Modified Date, Source Amount, Tax%, Final Amount, Invoice No, Actions
* Listing Actions: Add & Edit Log with file attachments
* Listing Actions: Single Click ajax delete
* Listing Actions: View details log as per capability

**CBX Accounting: Category Manager**

* Category based on Income and Expense
* Different color for different category for legend marking in different places.
* Filter: All Categories, Income Categories, Expense Categories
* Search Category by keywords
* Category Listing Heading: Title, Type, Added By, Modified By, Added Date , Modified Date, Color, Publish, Protected, ID
* Category Add, Edit, De
* Protected Category: Category created by 3rd party plugins or addon can not be edited from Category Edit option
* Category listing Bulk Options: Delete single or multiple category(if that category has no logs)

**CBX Accounting: Accounts Manager**

* Account Types: Cash or Bank
* Multiple Cash or Bank Account facility
* Export: PDF and Excel formats
* Search Accounts by keywords
* Account Listing Heading: Title, Type, Acc. No, Acc. Name, Bank Name, Bank Branch, Added By, Modified By, Added Date, Modified Date, ID
* Accounting Listing Bulk Options: Delete single or multiple if that account has no logs/entries connected

**CBX Accounting: Vendor Manager(Free Addon)**

* List vendor or client
* Vendor is related with expense, vendor gets payments(Expense)
* Client is related with income, clients gives payments(Income)
* Bulk Options: Delete single or multiple vendor if they are not connected to any logs/entries
* Search Vendor/Clients by keywords
* List Headings: Name, Type, Address, Contact Information, Connected User ID, ID
* Export: PDF and Excel formats
* View Vendor/Clients As readonly mode
* Add, Edit Vendor


**Free & Pro Addons**

* [Vendors and Clients Addon - Free](https://codeboxr.com/product/vendor-and-client-addon-for-cbx-accounting/)
* [Statement Addon - Pro](http://codeboxr.com/product/statement-addon-for-cbx-accounting)
* [Frontend Addon - Pro](https://codeboxr.com/product/frontend-addon-for-cbx-accounting/)
* [WooCommerce Addon - Pro](https://codeboxr.com/product/woocommerce-addon-for-cbx-accounting/)

== Installation ==

1. Upload `cbxwpsimpleaccounting.zip` to the `/wp-content/plugins/` directory or search in wordpress dir from wordpress for "CBX Accounting"
2. Activate the plugin through the 'Plugins' menu in WordPress
3. You'll now see a menu called "CBX Accounting" in left menu of word, start from there


== Screenshots ==

== Changelog ==

= 1.3.14 =

* [improvement] For rest api session init disabled
* [improvement] New Delete, Edit icon added
* [improvement] Overview latest income and expense now shows latest entries in place of latest entries from current month.
* [improvement] Various style improvements

= 1.3.13 =

* [new] PDF and Excel export : Choose cols as need, no force to export all cols. Added in frontend addon too.
* [fixed] Category pagination now includes the search param.


= 1.3.12 =

* [Improvement] Disable custom session handle for cron request
* [Improvement] Overall improvement

= 1.3.11 =

* [Improvement] Plugin branding improvement
* [Improvement] Admin ui improvement

= 1.3.10 =

* Tested with latest wordpress version
* Remove PHPExcel.php file from includes folder as it's not needed.

= 1.3.9 =

* Bug fix and improvements

= 1.3.9 =
* Bug fix and improvements
* All pro and free addons are updated

= 1.3.8 =
* [New] File attachment feature
* [Improvement] TCPDF is replaced with FPDF latest version with some other supported lib. No need extra plugin for TCPDF for this plugin, pls disable.
*  Minor improvements and bug fix
*  It is highly recommended that pro or free addons should be updated to their latest release for pdf and csv export compatibility

= 1.3.7 =
* [Bug] CSS and JS enqueue logic fix so that it works for other languages
* [Bug] Log export filter by account was not working, fixed.
* [Improvement] Lots of minor improvements as regular releases

= 1.3.6 =
* [Improvement] Minor improvements

= 1.3.5 =
* [Bug Fix] on uninstall database tables and options created by this plugin are deleted properly if set yet

= 1.3.4 =
* [Bug Fix] Decimal point store fixed

= 1.3.3 =
* [Bug Fix] Log edit decimal value save bug fixed
* [Improvement] Lots of minor improvement
* [Improvement] Log Add/Edit, Category Add/Edit, Account Add/Edit frontend form validation added