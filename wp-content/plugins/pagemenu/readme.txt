=== pagemenu ===
Contributors: Rick Mosher
Donate link: http://rickwright11.com/
Tags: dropdown, menus, css, database
Requires at least: 2.7.1
Tested on: 2.7.1

Pagemenu selects pages from the Wordpress database and presents them in a dropdown menu.

== Description ==
Pagemenu selects pages from the Wordpress database and presents them in a dropdown menu.

"Pagemenu" for Wordpress came about when I needed a way to get page titles from the database for a dropdown menu. It is a horizontal dropdown menu based on css properties and includes a css file. No javascript is required.

== Installation == 
Installation is normal; as for any Wordpress plugin just unzip to the Wordpress plugin directory plugins/pagemenu and activate by clicking activate on the wp admin plugin page

Add this php code "`<?php echo pagemenu() ?>`" with the appropriate php braces (if necessary) where you wish the menu to appear.

At this point there is no special configuration for "pagemenu". If you are familiar with php you can of course edit the php function ... not too difficult to read, I hope. Css options can of course also be adjusted to suit.

Using

Pagemenu selects page titles and page links from the database based upon the parent, you choose when you create the page.  Parent pages (ie: <em> pages not linked to other pages </em>) become the top menu item. 

When you want a page listed under a particular parent, just select the desired parent in the parent dropdown on the right side of the edit page menu in Wordpress Admin. (<em>or "Main Page (no parent)" if you want the page to be a parent</em>)

When you have more than 1 page, list the order  in which, you want them to appear <em>(just beneath the parent dropdown on the right side.)</em> </p>

== Other ==
Pagemenu is not currently configured for categories or posts.

Currently there is only 1 dropdown level, more to come. 

Go to my site: http://rickwright11.com/ if you need more or want you see the menu in action. You can also contact me from there. 
I will try to help; but keep in mind we all have to earn a living.