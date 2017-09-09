# Meet My Team #
**Contributors:** Buooy  
**Tags:** meet,my,team,members,staff,gallery,responsive,modal,grid  
**Requires at least:** 3.6  
**Tested up to:** 3.8.1  
**Stable tag:** 1.2.2  
**License:** GPLv2 or later  
**License URI:** http://www.gnu.org/licenses/gpl-2.0.html  

Meet My Team is an awesome way to display your team members in a grid with a modal for each team member!

## Description ##

Ever needed to display a lot of team members but you find it too lengthy to put into a single page? 

Meet My Team solves that problem by providing an intuitive interface that allows you to add your team members and display their information in a modal! Sounds great?

**Announcement**

If you had problems with a single column display, it was because we had some trouble with the Github to SVN pusher and the public.min.css file was missing. Have updated accordingly

Firstly, I'm sorry for the long time of absence. I've been extremely busy and I apologize to all who have been having problem with the plugin.

One of the biggest problem is the centering of the modal. This is likely caused by the modal javascript algorithm that is used to center the modal.

If it is giving you any problems, please use the disable_modal_centering attribute as follows: [meet-my-team cols="3" show_groups="" debug='true' disable_modal_centering='true']

The other issue is using the shortcode twice on the same page. This was due to me using "include" instead of "include_once". A careless mistake on my part. I have rectified as necessary.

I will address other issues once I get a chance

**Features**

1. Responsive Grid with Smooth Readjustments : We modified the bootstrap grid's naming convention so that it doesnt conflict with your bootstrap theme.
2. Responsive Modal Display : We utilised the well tested Reveal Modal from Zurb Foundation to build a responsive display of your individual theme.
3. Theme Agnostic : We implemented a minimal css strategy so that the plugin will fit in with any theme that you utilize.
4. Easy Styling Classes : We provided simple style classes that theme developers can use to target and style their own. More information about this coming
5. Insert into any page with our shortcode

**Supported Fields**

1. Team Member Name
2. Team Member Profile Picture
3. Team Member Email
4. Team Member Biography
5. Team Member Personal URL e.g. Facebook, Linkedin
... More Coming

## Installation ##

### Using The WordPress Dashboard ###

1. Navigate to the 'Add New' in the plugins dashboard
2. Search for 'Meet My Team'
3. Click 'Install Now'
4. Activate the plugin on the Plugin dashboard

### Uploading in WordPress Dashboard ###

1. Navigate to the 'Add New' in the plugins dashboard
2. Navigate to the 'Upload' area
3. Select `meet-my-team.zip` from your computer
4. Click 'Install Now'
5. Activate the plugin in the Plugin dashboard

### Using FTP ###

1. Download `meet-my-team.zip`
2. Extract the `meet-my-team` directory to your computer
3. Upload the `meet-my-team` directory to the `/wp-content/plugins/` directory
4. Activate the plugin in the Plugin dashboard


## Frequently Asked Questions ##

### How Do I Use The Plugin? ###

You can use it simply with this shortcode: [meet-my-team]

### What Shortcodes Are Available ###

We are currently working on a few, but as of now, we support the use of two options:

1. [meet-my-team cols="NUM"] Default: 3 where NUM can be 1,2,3,4,6. => cols will list out the number of cols of team members will be displayed in each row.

2. [meet-my-team parent_container_id="ID"] where ID can be the id of the overall container encapsulating the modals  => This is utilized more for theme developers who want to target the specific classes

3. [meet-my-team show_groups="GROUPS"] where GROUPS can be the different categories set forthe post

4. [meet-my-team display_modal="BOOLEAN"] where BOOLEAN is true or false. This can be used to enable or disable the modal

5. [meet-my-team align="ALIGN"] where ALIGN is left or center. This will allow the columns to be centered or left align.

6. [meet-my-team display_picture="BOOLEAN"] wwhere BOOLEAN is true or false. This will display the picture on the page (outside of the modal)

7. [meet-my-team disable_modal_centering="BOOLEAN"] wwhere BOOLEAN is true or false. This will disable the modal centering javascript


### What responsive grid are you using ###

We are actually using a modified version of bootstrap. It was designed to shrink to a single column from 768px and below. More options in the future.

### Something is broken? Want a particular feature? ###

Feel free to email us at ahoy@buooy.com.


## Screenshots ##

###1. Add a variety of information to each team member###
[missing image]

###2. Add to any page with our easy to use shortcode###
[missing image]

###3. Responsive grid that works across devices###
[missing image]

###4. Responsive Modal that displays each team member's information###
[missing image]


## Changelog ##

### 1.1.2 ###
* Fixed Bug that did not update the version

### 1.1.1 ###
* Fixed Bug that doesn't include js and css

### 1.1 ###
* New Features: More shortcodes are now available!
* New Features: Added categories to the members that can be used for groups
* Bug Fixes: Post order added back to rearrange team member hierarchy

### 1.0 ###
* Introduction to Meet My Team

## Upgrade Notice ##

None as of now