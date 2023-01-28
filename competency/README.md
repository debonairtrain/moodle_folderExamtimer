<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Read Me | Competency Theme</title>
    <script src="https://use.fontawesome.com/02c6d54247.js"></script>
</head>

<style>
    body {
        background: #f1f1f1;
        font-size: 14px;
        color: #444;
        max-width: 700px;
        margin: 120px auto;
    }
    a {
        color: #8e558e;
    }
    #header {
        background: #8e558e;
        padding: 15px;

    }
    #header .logo {
        text-align: center;
    }
    #footer {
        background: #fff;
        border-top: 1px solid #f1f1f1;
        padding: 20px;
    }
    #footer .social-links {
        text-align: center;
    }
    #footer .social-links ul {
        padding-left: 0;
        margin: 0;
    }
    #footer .social-links ul li {
        list-style: none;
        display: inline-block;
        margin: 0 10px;
    }
    #footer .social-links ul li a i {
        color: #000;
    }
    #footer .social-links ul li a:hover i:before {
        color: #8e558e;
        border-bottom: 1px solid #aaa;
        padding-bottom: 2px;
    }
    .read-me {
        background: #fff;
        padding: 20px 30px 30px;
    }
    .read-me h3 {
        color: #656565;
        font-size: 26px;
        font-weight: normal;
        border-bottom: 1px solid #aaa;
        padding-bottom: 10px;
    }
    .read-me p {

    }
    .read-me  ul {
        padding-left: 0;
    }
    .read-me  ul li {
        list-style: none;
        margin-bottom: 10px;
    }
    .read-me  ul li a {
        margin-left: 10px;
    }
    .logo h2 {
        color: #fff;
        font-size: 40px;
    }
</style>

<body>


<div class="content">
<div class="read-me">

<h3>About Competency Moodle 4.0 compliant theme</h3>

<p>The Competency theme is a special Boost child theme designed to enable focus on competencies in any discipline, for which learning plans are uploaded. </p>

<ul>

<li>Version : &nbsp; 2022111400 </li>

<li>Released on : &nbsp; 11 November 2022</li>

<li>Authors : &nbsp; Debonair Training development team</li>

<li>Copyleft &copy; 2022 onwards <a href="https://debonairtraining.com">www.debonairtraining.com</a></li>

</ul>

<h3>Supported Moodle versions</h3>

<p>Compatible with Moodle 4.0</p>

<h3>Supported browsers</h3>

<p>IE9+ <br /><br />
Recent versions of all modern browsers
</p>

<h3>Competency theme - Installation steps</h3>

<ul>

<li>On your downloaded package, you will find theme_competency.zip</li>

<li>Unzip - theme_competency.zip, you will get folder 'competency'</li>

<li>Copy folder 'competency' and put into theme folder of your moodle system</li>

<li>Next login as Site administrator</li>

<li>Go to 'Site administration' -> 'Notifications' ,
here on 'Plugins check' page you will see the competency theme in listing.</li>

<li>Click the "Upgrade Moodle database now" button displayed on bottom of the page</li>

<li>You will get a success message once the theme is installed successfully.</li>

<li>By clicking "Continue" button on success page , you will get options to change the competency theme settings.</li>

<li>You can modify the settings later too :-)</li>

</ul>

<h3>Steps to set Competency theme as default theme for your Moodle system</h3>

<ul>

<li>Login as site administrator</li>

<li>Go to Site administration -> Appearance -> Themes -> Theme selector</li>

<li>Click the "Change theme" button for device type as "Default"</li>

<li>It will list all the available themes for "Default device"</li>

<li>Then click "Use theme" button on "Competency theme"</li>

<li>Next click the "Continue" button, thats it!</li>

<li>Cheers,you have done it !!!</li>

<li>If you need any support related to this theme , kindly send an email to <a href="mailto:info@debonairtraining.com">info@debonairtraining.com</a></li>



</ul>

<h3>Steps to configure Competency theme</h3>
ul>

<li>Login as site administrator</li>

<li>Go to Site administration -> Appearance -> Competency Themes </li>

<li>Click the "General Setting" And set all necessary settings</li>

<li>Click the "Custom Image Setting" to set the favicon image, Header image and other images</li>

<li>Click the "Icon Navigation" to set the icons menu</li>

<li>Click the "Marketing Tiles" to set the promoted courses or courses you may be interested in</li>
<li>Click the "Categories Tiles" to set the categories</li>
<li>Follow the steps above to carry out other settings</li>

<li>Cheers, you have done it !!!</li>

</ul>

<h3>Developer Documentation</h3>

<ul>

    <li><b>Front page</b></li>

<li>The header image is dynamically uploaded from the theme settings: Site administration --> Themes --> Competency theme --> Then Custom image tab for Header Image. </li>

<li>The Colour scheme can be dynamically set using the colour pickers in: Site administration --> Themes --> Competency theme. Note SCSS can be added, or directly in the scss files for advanced developers. </li>

<li>The header Title "Get Competitive Advantage with E-Learning" can be changed to one of choice in others.mustache</li>

<li>The best, worst and competency path are programmed in the core_renderer.php, dashboard_matrix function and dashboard.mustache files</li>

<li>The Search bar is in the core_renderer and search.mustache. </li>

<li>The Metrics, Time, Certification and classes icons can be changed in the core_renderer and fpicons.mustache</li>

<li>Categories and Marketing tiles can be dynamically uploaded from the theme settings site administration --> Themes --> Competency theme --> "Marketing Tiles"
"Categories Tiles" tabs respectively. </li>

<li>Default front page settings still apply after any of the above enabled functionalities are enabled / rendered. </li>

<li>The Footer is setup in footer.mustache</li><br>

    <li><b>Dashboard</b></li>

<li>The dashboard comes with default theme_boost blocks of Timeline and Calendar. Blocks can be added by clicking on the blocks drawer. They can be removed at Site Administration -> Plugins -> Blocks and hiding the unwanted blocks, for example Calendar</li>

<li><b>My Courses</b></li>

<li>All the courses the user is enrolled in; will show here by default and it is similar to the course overview block which can be added to the dashboard</li>

<li>Theme settings </li>

<li>Theme settings including a Custom Menu can be added/adjusted similar the method of adding it in Moodle3.x </li>

</ul>
<br>

<ul>
    <li><b>Bespoke Support</b></li>

<li>For more information, support or bespoke customisation, please contact us at <a href="mailto:info@debonairtraining.com">info@debonairtraining.com</a> </li>

<li>Theme Version : &nbsp; 4.0 </li>
 
<li>Released on : &nbsp; 11 November 2022</li>

<li>Authors : &nbsp; Debonair Training development team</li>

<li>Copyleft &copy; 2022 onwards <a href="https://debonairtraining.com">www.debonairtraining.com</a></li>

</ul>

</div>
</div>


</body>
</html>
