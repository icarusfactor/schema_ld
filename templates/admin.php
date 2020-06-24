<link rel="stylesheet" type="text/css" href="<?php echo plugins_url(); ?>/schema_ld/assets/view.css" media="all">
<script type="text/javascript" src="<?php echo plugins_url(); ?>/schema_ld/assets/view.js"></script>
<script type="text/javascript" src="<?php echo plugins_url(); ?>/schema_ld/assets/tabs.js"></script>
<link rel="stylesheet" type="text/css" href=""<?php echo plugins_url(); ?>/schema_ld/assets/tabs.css">

<div class="tab">
  <button class="tablinks" onclick="openTab(event, 'BLOGCONFIG')">BLOG SCHEMA CONFIG</button>
  <button class="tablinks" onclick="openTab(event, 'DOMAINPRELOADS')">DOMAIN PRELOADS</button>
  <button class="tablinks" onclick="openTab(event, 'AUTOMATEDINFO')">AUTOMATED INFO</button>
  <button class="tablinks" onclick="openTab(event, 'MANUALINFO')">MANUAL INFO</button>
  <button class="tablinks" onclick="openTab(event, 'ABOUTINFO')">ABOUT</button>
</div>


<div id="DOMAINPRELOADS" class="tabcontent">
<h3 style="font-size: 14px;"  >Preload Schema LD Defaults for Domain Specific fields</h3>

<ul >
<li id="li_1" >
<div>
<label class="description" for="genre">GENRE:</label>
<button onclick="loadDomain1();return false;">chiropractor</button>
<button onclick="loadDomain2();return false;">dentist</button>

</div><p class="guidelines" id="guide_1"><small>Load selected field into configs.</small></p>
</li>
<li id="li_2" >
<div>
</div>
</li
</ul>
</form>
</div>


<div id="ABOUTINFO" class="tabcontent">
<h3>Schema LD Plugin</h3>
<img width="350" height="350" src="<?php echo plugins_url(); ?>/schema_ld/assets/schema_ld_logo.png" />

<pre>
Designed to help facialite json-ld entries
into blogs and manual entry into posts and
pages. 

</pre>
</div>

<div id="MANUALINFO" class="tabcontent">

<h3 style="font-size: 14px;" > Manual Method </h3>
<pre style="font-size: 10px;"  >
This DIV and CSS method is a good way to wrap the
schema_ld code in so it would never show up, even
if plugin is disabled or something goes wrong or
upon upgrading.

&#x3C;div style=&#x22;display: none; visibility: hidden;&#x22; &#x3E;[schema_ld] SCHEMEA JSONLD MARKUP GOES HERE [/schema_ld]&#x3C;/div&#x3E; 

In below example the only schema-ld code you would place between
the tags would be between the SNIP sections.
</pre>

<h3 style="font-size: 14px;" >  Example Carousel </h3>
<pre style="font-size: 10px;"  >
&#x3C;script type=&#x22;application/ld+json&#x22;&#x3E;
{

------------SNIP----------------

 &#x22;@context&#x22;:&#x22;http://schema.org&#x22;,
 &#x22;@type&#x22;:&#x22;ItemList&#x22;,
 &#x22;itemListElement&#x22;:[
 {
 &#x22;@type&#x22;:&#x22;ListItem&#x22;,
 &#x22;position&#x22;:1,
 &#x22;url&#x22;:&#x22;http://example.com/desserts/apple-pie&#x22;
 },
 {
 &#x22;@type&#x22;:&#x22;ListItem&#x22;,
 &#x22;position&#x22;:2,
 &#x22;url&#x22;:&#x22;http://example.com/desserts/cherry-pie&#x22;
 },
 {
 &#x22;@type&#x22;:&#x22;ListItem&#x22;,
 &#x22;position&#x22;:3,
 &#x22;url&#x22;:&#x22;http://example.com/desserts/blueberry-pie&#x22;
 }
 ]

------------SNIP----------------

}
&#x3C;/script&#x3E;
</pre>

</div> <!-- END OF MANUALINFO  -->


<div id="AUTOMATEDINFO" class="tabcontent">

<h3 style="font-size: 14px;" >Automated Method</h3>
<h3 style="font-size: 14px;" >Using Classic Editor Buttons </h3>
<pre style="font-size: 10px;" >
With this plugin you should
have 3 buttons added in the
wordpress classic editor that
will show up on the text tab.

1: Add Blog schema-ld automatically
 Step by step dialog entry process
2: Remove Blog schema-ld automatically
 Will clear out and old or schema that has errors in it. 
3: Check your schema against <a target="_blank" href="https://search.google.com/structured-data/testing-tool" >Google's strcutured Text Validator</a>.

<i>You'll want to cut and paste this text</i>
<i>in your local notepad becasue the dialogs</i>
<i>will disappear if you click into another</i>
<i>browser window or tab</i>
<b>Enter in each dialog as follows:</b>

<b>Title :</b> Title Of Blog.
<b>Subtitle:</b> This is the subtitle of the blog post. 
<b>Image URL:</b> http://example.com/image_specific_to_blog.png (Will try to find first image in text and autofill)
<b>Keywords:</b> Dentist Doctor healthcare 
<b>Description:</b> This is a basic description of the post. 
<b>Body:</b> This is a longer version of the desciption and may a pargraph or two. 
<b>Author:</b> This is you.


Title: Will be auto-filled if you have H1 H2 H3 tags.
Subtitle: Will be auto-filled if you have H2 H3 H4 tags.
Image URL: Will be auto filled if you have an IMG in your article.
Keywords: Will be auto filled and tested against approved keywords in admin section.

Description: Will not be autofilled and should gather this info onto a note before start.
Blurb: Will not be autofilled and should gathered before start.
Author: Will not be autofilled and author will use their own name.

</pre>

</div> <!-- END OF AUOTMATEDINFO  -->


<div id="BLOGCONFIG" class="tabcontent">

<form id="form_101687" class="appnitro"  method="post" action="">
                                        <div class="form_description">
                        <h3 style="font-size: 14px;font-weight: 600;"  >Blog Schema Lightweight Directory Form Defaults</h3>
                        <h3 id="display_rec" ><span style="font-size: 10px;color: red;" >All values are !REQUIRED!</span></h3>
                </div>
                        <ul >

                                        <li id="li_1" >
                <label class="description" for="element_1">GENRE:</label>
                <div>
                        <input id="element_1" name="element_1" class="element text small" type="text" maxlength="255" value=""/> 
                </div><p class="guidelines" id="guide_1"><small>Blog Posts Will Generally Be About Field Of : </small></p> 
                </li>           <li id="li_2" >
                <label class="description" for="element_2">DOMAIN KEYWORDS </label>
                <div>
                        <textarea id="element_2" name="element_2" class="element textarea large"></textarea> 
                </div><p class="guidelines" id="guide_2"><small>Words that the filed will be recognized as performing.</small></p> 
                </li>           <li id="li_3" >
                <label class="description" for="element_3">Blog Publisher  </label>
                <div>
                        <input id="element_3" name="element_3" class="element text medium" type="text" maxlength="255" value=""/> 
                </div><p class="guidelines" id="guide_3"><small>Copyright Under</small></p> 
                </li>           <li id="li_4" >
                <label class="description" for="element_4">Blog Logo URL</label>
                <div>
                        <input id="element_4" name="element_4" class="element text large" type="text" maxlength="255" value=""/> 
                </div><p class="guidelines" id="guide_4"><small>URL of Publisher logo.</small></p> 
                </li>
                        <li id="li_5" >
                <label class="description" for="element_5">Logo Width</label>
                <div>
                        <input id="element_5" name="element_5" class="element text small" type="text" maxlength="16" value=""/>
                </div><p class="guidelines" id="guide_5"><small>Logo Width</small></p>
         </li>       
                 <li id="li_6" >
                <label class="description" for="element_6">Logo Height</label>
                <div>
                        <input id="element_6" name="element_6" class="element text small" type="text" maxlength="16" value=""/>
                </div><p class="guidelines" id="guide_6"><small>Logo Height</small></p>
         </li>       



                                        <li class="buttons">
                            <input type="hidden" name="form_id" value="101687" />
                            <input type="hidden" name="if_ajaxid"  value="002">
                            
                            <input id="saveForm" class="button_text" type="submit" name="submit" value="SAVE" />
                </li>
                        </ul>
</form>

</div> <!-- END OF BLOGCONFIG  -->


<script> 
  //load up Wordpress options into input fields
  var input_genre = document.getElementById("element_1"); 
  var input_keyword = document.getElementById("element_2"); 
  var input_pub = document.getElementById("element_3"); 
  var input_publogo = document.getElementById("element_4"); 
  var input_publogow = document.getElementById("element_5"); 
  var input_publogoh = document.getElementById("element_6"); 

  try {
      var schema_ldObj = JSON.parse( '<?php echo get_option('schema_ld_configs' ); ?>' );
      }
  catch(err) {
      var schema_ldObj = "";
      }
 
  input_genre.value = schema_ldObj.domain; 
  input_keyword.value = schema_ldObj.domain_keywords; 
  input_pub.value = schema_ldObj.publisher; 
  input_publogo.value = decodeURIComponent(schema_ldObj.publisher_logo); 
  input_publogow.value = schema_ldObj.publisher_logow; 
  input_publogoh.value = schema_ldObj.publisher_logoh; 


  //Start with About in view
  setTab('ABOUTINFO')

</script> 


<script> 
  //Preload Wordpress options into config client side fields

var domain_string1 = "chiropractor";
var domain_keywords_string1 = "adjustment " +
"advanced " +
"back " +
"benefits " +
"best " +
"care " +
"center " +
"cervical " +
"chiro " +
"chiropractic " +
"chiropractor " +
"chiropractors " +
"clinic " +
"cost " +
"decompression " +
"doctor " +
"doctors " +
"family " +
"female " +
"health " +
"local " +
"location " +
"lumbar " +
"massage " +
"medicine " +
"near " +
"neck " +
"nerve " +
"office " +
"pain " +
"pediatric " +
"pinched " +
"prenatal " +
"prices " +
"problems " +
"relief " +
"spinal " +
"sports " +
"therapy " +
"treatment " +
"wellness ";

var domain_string2 = "dentist";
var domain_keywords_string2 = "area " +
"best " +
"bleaching " +
"bridge " +
"canal " +
"care " +
"clinic " +
"cosmetic " +
"cost " +
"dental " +
"dentist " +
"dentistry " +
"dentures " +
"emergency " +
"endodontist " +
"extraction " +
"family " +
"filling " +
"find " +
"general " +
"hygiene " +
"implant " +
"implantation " +
"implants " +
"kids " +
"local " +
"near " +
"office " +
"oral " +
"orthodontist " +
"pediatric " +
"porcelain " +
"practice " +
"removal " +
"root " +
"search " +
"surgeon " +
"surgery " +
"teeth " +
"tooth " +
"treatment " +
"urgent " +
"veneers " +
"whitening " +
"wisdom ";


function loadDomain1(){
  var input_genre = document.getElementById("element_1"); 
  var input_keyword = document.getElementById("element_2"); 
  //console.log( window.domain_string1 );
  //console.log( window.domain_keywords_string1 );

  input_genre.value = domain_string1; 
  input_keyword.value = domain_keywords_string1; 
}

function loadDomain2(){
  var input_genre = document.getElementById("element_1"); 
  var input_keyword = document.getElementById("element_2"); 
  //console.log( window.domain_string2 );
  //console.log( window.domain_keywords_string2 );

  input_genre.value = domain_string2; 
  input_keyword.value = domain_keywords_string2; 
}



</script> 


