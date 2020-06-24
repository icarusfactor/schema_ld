<?php
/**
 * @package  schema_ld
 */
/*
Plugin Name: Schmea LD Plugin
Plugin URI: http://userspace.org
Description: Ths plugin will let you easily add blocks of formated Google schmea json-ld definitions
Version: 1.2.0
Author: Daniel Yount aka "icarus factor"
Author URI: http://userspace.org
License: GPLv2 or later
Text Domain: schmea_ld-plugin
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2020 Daniel Yount.
*/

defined( 'ABSPATH' ) or die( 'Hey, what are you doing here? You silly human!' );

if ( !class_exists( 'SchmealdPlugin' ) ) {

	class SchemaldPlugin
	{

		public $plugin;

		function __construct() {
			$this->plugin = plugin_basename( __FILE__ );
		}

		function register() {

	          add_action( 'admin_menu', array( $this, 'add_admin_pages' ) );
                  wp_enqueue_script( 'quicktags' );
                  wp_enqueue_script( 'jquery' );
                  add_action('admin_print_footer_scripts', array( $this, 'add_quicktags') );      
                  add_action('wp_ajax_nopriv_ajaxrp_do_something', array($this, 'sld_do_something_serverside'));
		  add_action('wp_ajax_ajaxsld_do_something', array($this, 'sld_do_something_serverside')); /* notice green_do_something appended to action name of wp_ajax_ */
		  add_action( 'admin_enqueue_scripts', array( $this, 'sld_enqueue' ) );


		}

                function sld_enqueue() {

                wp_enqueue_style('sldbootcss','https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css');
                wp_enqueue_script( 'sldpopper', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js');
                wp_enqueue_script( 'sldboot','https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js');

                wp_enqueue_script('ajaxsld_script', plugin_dir_url(__FILE__) . 'assets/ajax_call_to_handle_form_submit.js');
                wp_localize_script('ajaxsld_script', 'ajaxsld_object', array('ajaxsld_url' => admin_url('admin-ajax.php'), 'if_ajaxid' => 002));

                }


                function sld_do_something_serverside() {
                        //Use this value to validate each data to only this set.
                        $unique_value = $_POST['if_ajaxid'];
                        if ( $unique_value == '002' ){

                         // output to ajax call   
                         $domain = $_POST['element_1'];
                         $domain_keywords = $_POST['element_2'];
                         $publisher = $_POST['element_3'];
			 $publisher_logo = $_POST['element_4'];
			 $publisher_logow = $_POST['element_5'];
			 $publisher_logoh = $_POST['element_6'];

                         $pubconv = urlencode( $publisher_logo );

                         if ( $domain=='' OR $domain_keywords=='' OR $publisher =='' OR $publisher_logo='' ){
                                echo "false";
                                }else {

                                //Need to get and check dimsions of image. 
                                //$publisher_logow = 280;
                                //$publisher_logoh = 280;

                                //Need to convert all configs to json and save in variable
                                $schema_ldObj->domain = $domain;
				$schema_ldObj->domain_keywords = $domain_keywords;
				$schema_ldObj->publisher = $publisher;
				$schema_ldObj->publisher_logo =  $pubconv;
				$schema_ldObj->publisher_logow = $publisher_logow;
				$schema_ldObj->publisher_logoh = $publisher_logoh;

				$schema_ldJSON = json_encode($schema_ldObj);
                                

                                update_option( 'schema_ld_configs', $schema_ldJSON ); 

                                //Will be saved.
                                echo "true";
                                }
 


                        } //end of unique id check

                        die();
			}
               

                function get_the_slug( $id = null ){
		        $post = get_post($id);
		        if( !empty($post) ) return $post->post_name;
		        return ''; // No global $post var or matching ID available.
			    }

                 

                //Add buttons to classic editor
                function add_quicktags( $qtInit, $editor_id = 'content' )
                                        {

                                    global $wp;
				    $current_url = add_query_arg( $wp->query_string, '', home_url( $wp->request ) ); 
                                    $current_slug = $this->get_the_slug( $_REQUEST['post'] );
                                    $permalink_urlencoded = urlencode( $current_url."/".$current_slug."/" );  
                                    
                                  ?>
				  <script type="text/javascript">
                                  QTags.addButton( 'add_blog_schema', 'schema-ld(BLOG)',add_blog_schema);
                                  QTags.addButton( 'remove_tag_schema', 'schema-ld(REMOVE)',remove_tag_schema);
                                  QTags.addButton( 'check_blog_schema', 'schema-ld(CHECK)',check_blog_schema);

                                  


                                  function remove_tag_schema() {

                                    var texar =  document.querySelector('textarea#content.wp-editor-area').value;
                                    var index_start = texar.match(/<div id=\"schema-ld\".*>/).index;
                                    var index_end = texar.match(/\[\/schema_ld]\<\/div>/).index;
                                    var res = texar.slice( index_start , index_end + 18 );
                                    var newStr = texar.replace( res , '');
                                   document.querySelector('textarea#content.wp-editor-area').value = newStr; 
                                  }



                                  function setSelectionRange(input, selectionStart, selectionEnd) {
				     if (input.setSelectionRange) {
					input.focus();
    					input.setSelectionRange(selectionStart, selectionEnd);
					  }
				     else if (input.createTextRange) {
					var range = input.createTextRange();
					    range.collapse(true);
					    range.moveEnd('character', selectionEnd);
					    range.moveStart('character', selectionStart);
					    range.select();
  				 	 }
                                  }


				  function HasSchema() {

                                            var str = document.querySelector('textarea#content.wp-editor-area').value;
                                            var found = str.match(/<div id=\"schema-ld\".*>/); 
                                            if( found ) { return true;}
                                            return false;
                                  }	


				  function getMainIMGSrc() {

                                            var str = document.querySelector('textarea#content.wp-editor-area').value;
                                            var src ="";
                                            var regex="";
                                            regex = /<img.*?src=["|\'](.*?)["|\']/i;
                                            if( str.match(/<img/i) ) { src = regex.exec(str)[1];return src;}
                                            return src;
                                  }	

                                  function getHEADINGtag(str, num){
                                     if( str != "") {
                                        var b = str.match(/<h(.)>.*?<\/h\1>/gi); 
                                        var fin = b[num].replace(/<(.|\n)*?>/g, '');
                                        //console.log( fin );
                                        return fin; 
                                        }                                          
                                     return "";
                                  }
	

				  function setHEADINGtags() {

                                    var str = document.querySelector('textarea#content.wp-editor-area').value;
                                 		 regexH1 = /<H1>.*?<\/H1>/i;
                                  		 regexH2 = /<H2>.*?<\/H2>/i;
                                  		 regexH3 = /<H3>.*?<\/H3>/i;
                                  		 regexH4 = /<H4>.*?<\/H4>/i;
                                                            var str1 = str.match(regexH1);
                                                            var str2 = str.match(regexH2);
                                                            var str3 = str.match(regexH3);
                                                            var str4 = str.match(regexH4);
                                                            var he1=0,he2=0; 
                                                            var retstr="";
                                                 if( str1 != null ) {
                                                 //console.log("H1:"+str1 );
                                                      retstr = str1;
                                                      he1=1;
                                                      }
                                                 if( str2 != null ) {
                                                 //console.log("H2:"+str2 );
                                                      if(he1 == 0  ){ he1=2;retstr = str2;  } else { he2=2;retstr=retstr+str2;}
						      }
                                                 if( str3 != null  ) {
                                                 //console.log("H3:"+str3 );
                                                      if(he1 == 0 ){ he1=3;retstr=str3;}
                                                      else if(he2 == 0 ){ he2=3;retstr=retstr+str3; }
						      }
                                                 if( str4 != null ) {
                                                 //console.log("H4:"+str4 );
                                                      if(he1 == 0 ){ he1=4;retstr=str4;} 
                                                      else if(he2 == 0 ){ he2=4;retstr=retstr+str4; }
 						      }
                                                 //console.log("HE1:"+he1+"HE2:"+he2 );
                                                 //console.log("RETSTR:"+retstr );
                                                 return retstr;
                                                                }

                                  function setCaretToPos (input, pos) {
					    setSelectionRange(input, pos, pos);
				 }



                                  function get_word_count() {
                                  return document.querySelectorAll("span.word-count")[0].innerText;
                                  }

                                  function check_blog_schema() {
                                     var schema_check_url = 'https://search.google.com/structured-data/testing-tool#url=<?php echo $permalink_urlencoded; ?>';
                                     console.log( "URL:"+schema_check_url );
                                     window.open(schema_check_url , '_blank');
                                     }


				 function uniq(a) {
					    var prims = {"boolean":{}, "number":{}, "string":{}}, objs = [];

					    return a.filter(function(item) {
					    var type = typeof item;
					    if(type in prims)
					    return prims[type].hasOwnProperty(item) ? false : (prims[type][item] = true);
        				   else
	            			   return objs.indexOf(item) >= 0 ? false : objs.push(item);
   					   });
					  }

				function getkeywords( text ) {

                                        var stopWords = [ "a","able","about","above","abroad","according","accordingly","across","actually","adj","after","afterwards","again","against","ago","ahead","ain't","all","allow","allows","almost","alone","along","alongside","already","also","although","always","am","amid","amidst","among","amongst","an","and","another","any","anybody","anyhow","anyone","anything","anyway","anyways","anywhere","apart","appear","appreciate","appropriate","are","aren't","around","as","a's","aside","ask","asking","associated","at","available","away","awfully","b","back","backward","backwards","be","became","because","become","becomes","becoming","been","before","beforehand","begin","behind","being","believe","below","beside","besides","best","better","between","beyond","both","brief","but","by","c","came","can","cannot","cant","can't","caption","cause","causes","certain","certainly","changes","clearly","c'mon","co","co.","com","come","comes","concerning","consequently","consider","considering","contain","containing","contains","corresponding","could","couldn't","course","c's","currently","d","dare","daren't","definitely","described","despite","did","didn't","different","directly","do","does","doesn't","doing","done","don't","down","downwards","during","e","each","edu","eg","eight","eighty","either","else","elsewhere","end","ending","enough","entirely","especially","et","etc","even","ever","evermore","every","everybody","everyone","everything","everywhere","ex","exactly","example","except","f","fairly","far","farther","few","fewer","fifth","first","five","followed","following","follows","for","forever","former","formerly","forth","forward","found","four","from","further","furthermore","g","get","gets","getting","given","gives","go","goes","going","gone","got","gotten","greetings","h","had","hadn't","half","happens","hardly","has","hasn't","have","haven't","having","he","he'd","he'll","hello","help","hence","her","here","hereafter","hereby","herein","here's","hereupon","hers","herself","he's","hi","him","himself","his","hither","hopefully","how","howbeit","however","hundred","i","i'd","ie","if","ignored","i'll","i'm","immediate","in","inasmuch","inc","inc.","indeed","indicate","indicated","indicates","inner","inside","insofar","instead","into","inward","is","isn't","it","it'd","it'll","its","it's","itself","i've","j","just","k","keep","keeps","kept","know","known","knows","l","last","lately","later","latter","latterly","least","less","lest","let","let's","like","liked","likely","likewise","little","look","looking","looks","low","lower","ltd","m","made","mainly","make","makes","many","may","maybe","mayn't","me","mean","meantime","meanwhile","merely","might","mightn't","mine","minus","miss","more","moreover","most","mostly","mr","mrs","much","must","mustn't","my","myself","n","name","namely","nd","near","nearly","necessary","need","needn't","needs","neither","never","neverf","neverless","nevertheless","new","next","nine","ninety","no","nobody","non","none","nonetheless","noone","no-one","nor","normally","not","nothing","notwithstanding","novel","now","nowhere","o","obviously","of","off","often","oh","ok","okay","old","on","once","one","ones","one's","only","onto","opposite","or","other","others","otherwise","ought","oughtn't","our","ours","ourselves","out","outside","over","overall","own","p","particular","particularly","past","per","perhaps","placed","please","plus","possible","presumably","probably","provided","provides","q","que","quite","qv","r","rather","rd","re","really","reasonably","recent","recently","regarding","regardless","regards","relatively","respectively","right","round","s","said","same","saw","say","saying","says","second","secondly","see","seeing","seem","seemed","seeming","seems","seen","self","selves","sensible","sent","serious","seriously","seven","several","shall","shan't","she","she'd","she'll","she's","should","shouldn't","since","six","so","some","somebody","someday","somehow","someone","something","sometime","sometimes","somewhat","somewhere","soon","sorry","specified","specify","specifying","still","sub","such","sup","sure","t","take","taken","taking","tell","tends","th","than","thank","thanks","thanx","that","that'll","thats","that's","that've","the","their","theirs","them","themselves","then","thence","there","thereafter","thereby","there'd","therefore","therein","there'll","there're","theres","there's","thereupon","there've","these","they","they'd","they'll","they're","they've","thing","things","think","third","thirty","this","thorough","thoroughly","those","though","three","through","throughout","thru","thus","till","to","together","too","took","toward","towards","tried","tries","truly","try","trying","t's","twice","two","u","un","under","underneath","undoing","unfortunately","unless","unlike","unlikely","until","unto","up","upon","upwards","us","use","used","useful","uses","using","usually","v","value","various","versus","very","via","viz","vs","w","want","wants","was","wasn't","way","we","we'd","welcome","well","we'll","went","were","we're","weren't","we've","what","whatever","what'll","what's","what've","when","whence","whenever","where","whereafter","whereas","whereby","wherein","where's","whereupon","wherever","whether","which","whichever","while","whilst","whither","who","who'd","whoever","whole","who'll","whom","whomever","who's","whose","why","will","willing","wish","with","within","without","wonder","won't","would","wouldn't","x","y","yes","yet","you","you'd","you'll","your","you're","yours","yourself","yourselves","you've","z","zero"  ];


                                        //var matchingWords = [ "adjustment","advanced","back","benefits","best","care","center","cervical","chiro"," chiropractic","chiropractor","chiropractors","clinic","decompression","doctor","doctors","family","female","health ","location","lumbar"," massage","medicine","neck ","nerve","pain","pediatric","pinched ","prenatal ","problems","relief","spinal","sports","therapy","treatment","wellness" ]; 
                                       var s_ldObj = JSON.parse( ' <?php echo get_option( 'schema_ld_configs' ); ?> ' ); 
                                       var matchingWords = s_ldObj.domain_keywords.split(' ');
                                       console.log( matchingWords );

					var newtext = text.replace(/(<([^>]+)>)/ig,"");

					// Convert to lowercase
					newtext = newtext.toLowerCase();

					// replace unnesessary chars. leave only chars, numbers and space
					newtext = newtext.replace(/[^\w\d ]/g, '');

					var result = newtext.split(' ');

					// remove $stopWords
					result = result.filter(function (word) {
					return stopWords.indexOf(word) === -1;
                                        //Need to cross ref matchingWords here. 
					});


					//console.log(result);
                                        // Only keep key words that are domain approved. 
					var result2 = result.filter(function (word) {
                                        //console.log( matchingWords.indexOf(word) );
					return matchingWords.indexOf(word) >=1;
                                        //Need to cross ref matchingWords here. 
					});
                                         

					// Unique words
                                        result2 = uniq( result2 );
					//console.log(result2);
                                        var fin = result2.join();
                                        
                                        fin = fin.replace(/,/g, ' '); 
					//console.log(fin);
                                        return fin;
                                        }


                                  function add_blog_schema() {
                                     //need to check if schema_ld already exist in page, if just return.   
	                             if( HasSchema() ) {return;} //has schema return and do not go further.


                                     var s_ldObj = JSON.parse( ' <?php echo get_option( 'schema_ld_configs' ); ?> ' ); 

				     var headings = setHEADINGtags();
                                     var schemald_blog_title = "";
                                     var schemald_blog_title_default = getHEADINGtag(headings,0);
                                     var schemald_blog_subtitle = "";  
                                     var schemald_blog_subtitle_default = getHEADINGtag(headings,1);
                                     var schemald_blog_image = "";
                                     //Check if image exist in text , if so use it
                                     var schemald_blog_image_default = getMainIMGSrc();
				     var schemald_blog_genre = "";
                                     var schemald_blog_keywords = "";
                                     //check if approved domain keywords exist in text, if so use them.
				     var schemald_blog_keywords_default = getkeywords( document.querySelector('textarea#content.wp-editor-area').value );
                                     var schemald_blog_desc = "";
                                     var schemald_blog_desc = ""; 

	
				     schemald_blog_title = prompt( 'Title:', schemald_blog_title_default );
                                     var holdStr = schemald_blog_title.replace( /"/g,'')
                                     schemald_blog_title = holdStr; 
                                     if (schemald_blog_title === null) {return;}

				     schemald_blog_subtitle = prompt( 'Subtitle:', schemald_blog_subtitle_default );
                                     holdStr = schemald_blog_subtitle.replace( /"/g,'')
                                     schemald_blog_subtitle = holdStr; 
                                     if (schemald_blog_subtitle === null) {return;}

				     schemald_blog_image = prompt( 'Image URL:', schemald_blog_image_default );
                                     holdStr = schemald_blog_image.replace( /"/g,'')
                                     schemald_blog_image = holdStr; 
                                     if (schemald_blog_image === null) {return;}

                                     schemald_blog_genre = s_ldObj.domain ; 
                                     if (schemald_blog_genre === null) {return;}

				     schemald_blog_keywords = prompt( 'Keywords(Seprated By Spaces):', schemald_blog_keywords_default );
                                     holdStr = schemald_blog_keywords.replace( /"/g,'')
                                     schemald_blog_keywords = holdStr; 
                                     if (schemald_blog_keywords === null) {return;}

                                     //console.log( "PERMLINK: <?php echo $current_url."/".$current_slug."/";  ?>");

                                     //Hard code these values for now:
                                     //Need to make settings file and section in admin area.


                                     var schemald_blog_pub = s_ldObj.publisher;   
                                     var schemald_blog_plogo = decodeURIComponent(s_ldObj.publisher_logo); 
                                     var schemald_blog_plogow = s_ldObj.publisher_logow;    
                                     var schemald_blog_plogoh = s_ldObj.publisher_logoh;    

				     schemald_blog_desc = prompt( 'Description:', '' );
                                     holdStr = schemald_blog_desc.replace( /"/g,'')
                                     schemald_blog_desc = holdStr; 
                                     if (schemald_blog_desc === null) {return;}

				     schemald_blog_body = prompt( 'Blurb:', '' );
                                     holdStr = schemald_blog_body.replace( /"/g,'')
                                     schemald_blog_body = holdStr; 
                                     if (schemald_blog_body === null) {return;}

				     schemald_blog_author = prompt( 'Author:', '' );
                                     holdStr = schemald_blog_author.replace( /"/g,'')
                                     schemald_blog_author = holdStr; 
                                     if (schemald_blog_author === null) {return;}

        //Make sure all entries are filled. Otherwise do not do anything. 
	if ( schemald_blog_title != "" &&
             schemald_blog_subtitle != "" &&
             schemald_blog_image != "" &&
             schemald_blog_genre != "" &&
             schemald_blog_keywords != "" &&
             schemald_blog_desc != "" &&
             schemald_blog_body != "" &&
             schemald_blog_author != ""
           ) {
	//QTags.insertContent('<div class="' + my_class +'"></div>');
        setCaretToPos( document.querySelector('textarea#content.wp-editor-area') , 0); 
	QTags.insertContent(
        '<div id="schema-ld" style="display: none; visibility: hidden;" >[schema_ld]' +
	'"@context": "https://schema.org",' +
	'"mainEntityOfPage": " <?php echo $current_url."/".$current_slug."/";  ?> " ,' + 
	'"@type": "BlogPosting", ' +
	'"headline": "' + schemald_blog_title + '", ' +
	'"alternativeHeadline": "' + schemald_blog_subtitle + '",' +
 	'"image": "'+ schemald_blog_image +'",' +
 	'"genre": "'+ schemald_blog_genre +'",' + 
	'"keywords": "'+ schemald_blog_keywords +'", ' +
	'"wordcount": "'+ get_word_count() +'", ' +
        '"publisher": { "@type": "Organization","name": "' + schemald_blog_pub + '",' +
    	'"logo": { "@type": "ImageObject", "url": "' + schemald_blog_plogo +
        '","width": ' + schemald_blog_plogow + ',"height": '+ schemald_blog_plogoh +' }},'+
	//'"url": " <?php echo esc_url( $current_url  ); ?> " ,' +
	'"url": " <?php echo $current_url."/".$current_slug."/";  ?> " ,' +
 	'"datePublished": " <?php echo date("Y-m-d H:i:s") ?> ",' +
	'"dateCreated":   " <?php echo date("Y-m-d H:i:s") ?> ",' +
	'"dateModified":  " <?php echo date("Y-m-d H:i:s") ?> ",' +
	'"description": "' + schemald_blog_desc + '",' +
	'"articleBody": "' + schemald_blog_body + '",' +
	'"author": { ' +
	'"@type": "Person",' +
   	'"name": "' + schemald_blog_author + '"' +
 	'}' +
	'[/schema_ld]</div>');
   			        }
						              }

                                  </script>  
                                  <?php
    				        }

		public function add_admin_pages() {
			add_menu_page( 'Schmea LD', 'Schmea LD', 'manage_options', 'schemald_plugin', array( $this, 'admin_index' ), 'dashicons-portfolio', 110 );
		}

		public function admin_index() {
			require_once plugin_dir_path( __FILE__ ) . 'templates/admin.php';
		}

		function activate() {
			require_once plugin_dir_path( __FILE__ ) . 'inc/schemald-plugin-activate.php';
			SchemaldPluginActivate::activate();
		}
	}




                function jsonld_insert( $atts , $content =null ) {

			$Content = strip_tags($content, '<br />');  
                        $Content = html_entity_decode( $Content );
			$Content = str_replace('”', '"', $Content); 
			$Content = str_replace('“', '"', $Content);



                        $Contents = "<script type=\"application/ld+json\">{";
                        $Contents .= $Content; 
			$Contents .= "}</script>";
		        return $Contents; 
                }  


	$schemaldPlugin = new SchemaldPlugin();
	$schemaldPlugin->register();

	// activation
	register_activation_hook( __FILE__, array( $schemaldPlugin, 'activate' ) );

	// deactivation
	require_once plugin_dir_path( __FILE__ ) . 'inc/schemald-plugin-deactivate.php';
	register_deactivation_hook( __FILE__, array( 'SchemaldPluginDeactivate', 'deactivate' ) );

        //Use hooks from parent plugin.  
	add_shortcode('schema_ld', 'jsonld_insert' );

}
