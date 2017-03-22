/*--------------------------------------------------------------------------------
Youmax BIZ v2.6 by Jake H. from CodeHandling
https://codecanyon.net/item/youmax-grow-your-youtube-and-vimeo-business/9989505
---------------------------------------------------------------------------------*/


/*------------------------------------------------------------------
[Table of contents]

1. Youmax Settings
2. DOM Initialization 
3. Options Initialization
4. Source Validation
5. Getters
    5.1 Channel Details
    5.2 Channel Playlists
    5.3 Playlist Videos
    5.4 Video Statistics
6. Setters
    6.1 Video Objects
    6.2 Playlist Objects
    6.3 Statistic Setters
7. Display List
8. Video Display Mechanisms
8. Sorting Handlers
9. Tab Handlers
9. Animation Handler
10.Load More Handler
12.Youmax Display Handler
11.Resize Handler
12.Utility Functions 
13.Youmax Main Function
-------------------------------------------------------------------*/

var youmaxLoggedInUser = {
	name 		:null,
	id 			:null,
	picture 	:null,
	token 		:null,
	apiKey		:null
};


(function($) {

	"use strict";

	var localSettings = {

		apiKey					:"AIzaSyAlhAqP5RS7Gxwg_0r_rh9jOv_5WfaJgXw",	
		channelLinkForHeader	:"https://www.youtube.com/user/yogahousem",	
		tabs:[
            {
                name:"Uploads",
                type:"youtube-channel-uploads",
                link:"https://www.youtube.com/user/yogahousem"
            }
		],
		maxResults				:"10",
		videoDisplayMode		:"popup",										
		minimumViewsPerDayForTrendingVideos:"5",							
		displayFirstVideoOnLoad	:true,
		defaultSortOrder 		:"recent-first",
		youmaxDisplayMode		:"grid", 
        
        youmaxBackgroundColor   :"#ECEFF1",
        itemBackgroundColor     :"#fbfbfb",
        headerBackgroundColor              :"rgb(0, 147, 165)",
        descriptionColor        :"#686868",
        viewsColor              :"#6f6f6f",
        controlsTextColor       :"black",
        titleFontFamily         :"Open Sans",           
        generalFontFamily       :"Roboto Condensed",
		
		offerBackgroundColor    :"#fbfbfb",
        offerTextColor          :"#686868",
        offerHighlightColor     :"#FFC107",
        
        titleFontSize           :"0.9",
        titleFontWeight         :"normal",
        descriptionFontSize     :"0.85",
        viewsDateFontSize       :"0.75",
        baseFontSize            :"16px", 
        
        offerTitleFontSize      :"1.3",
        offerDescriptionFontSize:"0.85",
        offerButtonFontSize     :"1",
        
        responsiveBreakpoints	:[600,900,1050,1600],
        gridThumbnailType		:"full",
        dateFormat				:"relative",
        loadMoreText            :"<i class=\"fa fa-plus\"></i>&nbsp;&nbsp;Show me more videos..",
        ctaText                 :"<i class=\"fa fa-envelope\"></i>&nbsp;&nbsp;Get me a consultation..",
		ctaLink                 :null,
        previousButtonText      :"<i class=\"fa fa-angle-left\"></i>&nbsp;&nbsp;Previous",
        nextButtonText          :"Next&nbsp;&nbsp;<i class=\"fa fa-angle-right\"></i>",
        loadingText             :"loading...",
        allDoneText             :"<i class=\"fa fa-times\"></i>&nbsp;&nbsp;All done..",

        showFixedPlayIcon       :false,
        iconShape               :"circle",        //circle|square
        showHoverAnimation      :false,
        playlistNavigation      :false,
        carouselMode            :false,
                
		videoCache				:[],
		aspectRatio				:360/640,
		pageToken				:null,
		nextPageToken			:null,
		currentPageToken		:null,
		previousPageToken		:null,
		clearListOnDisplay		:true,
		channelIdForSearch		:null,
		searchFlag				:false,
		allDoneFlag				:false,
        previousTabId           :null,
        popupAlignTop           :true,

	},

	init = function($youmaxPro) {
	
		var settings = $youmaxPro.data("settings");

		var youmaxWrapperStart = "<div class='yl-font-controller'>"
		var youmaxWrapperEnd = "</div>"
		var listWrapperStart = "<div class='yl-wrapper'>";
		var listWrapperEnd = "</div>";
		var channelHeader = "<div class='yl-header'></div>"
		
		var gridListSwitch = "<div class='yl-switch' title='Grid or List View' data-view='double-list'><i class='fa fa-bars'></i></div>";
		var listHeader = "<div class='yl-list-title'><div class='yl-tab-container'><i class='fa fa-bars'></i></div><select id='yl-sort-order'><option value='popular-first' selected>Popular first</option><option value='recent-first'>Recent first</option></select>"+gridListSwitch+"</div>";
		
		var inlineContainer = "<div class='yl-inline-container'></div>";
        var playlistNavigationName = "<div class='yl-showing-playlist-name'></div>";
        var listContainer = "<div class='yl-item-container'></div><br>";
		var loadMoreButton = "<div class='yl-load-more-button' data-text='"+settings.loadMoreText+"'>"+settings.loadMoreText+"</div>";
		var previousButton = "<div class='yl-previous-button' data-text='"+settings.previousButtonText+"'>"+settings.previousButtonText+"</div>";
		var nextButton = "<div class='yl-next-button' data-text='"+settings.nextButtonText+"'>"+settings.nextButtonText+"</div>";
		var ctaButton = "";
		var calloutContainer = "<div class='yl-callout-container'></div>";
		var loadingMechanism = "";

		if(settings.ctaLink!=null) {
			ctaButton = "<a href='"+settings.ctaLink+"' target='_blank'><div class='yl-cta-button'>"+settings.ctaText+"</div></a>";
		}/* else {
			$youmaxPro.addClass("yl-no-cta");
		}*/

		if(settings.loadingMechanism=="load-more") {
			loadingMechanism = loadMoreButton;
		} else {
			loadingMechanism = previousButton + nextButton;
		}
		
		$youmaxPro.empty().append(youmaxWrapperStart+channelHeader+listWrapperStart+listHeader+inlineContainer+playlistNavigationName+listContainer+loadingMechanism+ctaButton+calloutContainer+listWrapperEnd+youmaxWrapperEnd);
		showLoader($youmaxPro);
	},


    doOptions = function($youmaxPro){

    	var customCSS = "";
    	var headerBackgroundColor,lightHeaderColor;
    	var settings = $youmaxPro.data("settings");
        var youmaxId = $youmaxPro.attr("id");

    	clearSettings($youmaxPro);
    	settings.minimumViewsPerDayForTrendingVideos = parseInt(settings.minimumViewsPerDayForTrendingVideos,10);

    	//set date format
    	if(settings.dateFormat=="relative") {
    		convertDate = convertToRelativeDate;
    	} else if(settings.dateFormat=="specific") {
    		convertDate = convertToSpecificDate;
    	}

    	//set view - grid|list|double-list
    	handleYoumaxDisplay($youmaxPro);


    	//Youmax Background Color
    	customCSS += "#"+youmaxId+".youmax-pro {background-color: "+settings.youmaxBackgroundColor+";}";
    	customCSS += "#"+youmaxId+" .yl-load-more-button:hover {background: linear-gradient(to right,"+settings.youmaxBackgroundColor+","+settings.itemBackgroundColor+" 30%);}"

    	//Item Background Color
    	customCSS += "#"+youmaxId+" .yl-list-title select, #"+youmaxId+" .yl-item, #"+youmaxId+" .yl-load-more-button, #"+youmaxId+" .yl-previous-button, #"+youmaxId+" .yl-next-button {background-color: "+settings.itemBackgroundColor+";}"

    	//Views Color
    	customCSS += "#"+youmaxId+" .yl-view-bucket {color: "+settings.viewsColor+"; border-color: "+settings.viewsColor+";}";
    	customCSS += "#"+youmaxId+" .yl-date-bucket{color: "+settings.viewsColor+";}";
    	customCSS += "#"+youmaxId+" .yl-view-string{color: "+settings.viewsColor+";}";
		customCSS += "#"+youmaxId+" .yl-selected-tab:after{background-color:"+settings.viewsColor+";}";

    	//Description Color
    	customCSS += "#"+youmaxId+" .yl-description, #"+youmaxId+" .yl-item, #"+youmaxId+" .yl-loader, #"+youmaxId+" .yl-list-title {color:"+settings.descriptionColor+";}";

    	//Header Color
	   	customCSS += "#"+youmaxId+" .yl-view-bucket-seen {background-color: "+settings.headerBackgroundColor+";border-color: "+settings.headerBackgroundColor+"; color:white;}";
	   	customCSS += "#"+youmaxId+" .yl-grid .yl-view-bucket-seen {color: "+settings.headerBackgroundColor+"; background-color:inherit;}";
    	customCSS += "#"+youmaxId+" .yl-loader {border-color: "+settings.headerBackgroundColor+";}";
    	customCSS += "#"+youmaxId+" .yl-load-more-button, #"+youmaxId+" .yl-previous-button {box-shadow: 0 0px 2px rgba(0, 0, 0, 0.2), -0.2em 0px 0px 0px "+settings.headerBackgroundColor+";}";
    	customCSS += "#"+youmaxId+" .yl-list-title select{box-shadow: 0 0px 2px rgba(0, 0, 0, 0.2), -0.2em 0px 0px 0px "+settings.headerBackgroundColor+";}";
    	customCSS += "#"+youmaxId+" .yl-header, #"+youmaxId+" .yl-cta-button, #"+youmaxId+" .yl-switch, #"+youmaxId+" .yl-showing-playlist-name{background-color:"+settings.headerBackgroundColor+"; color:"+settings.headerTextColor+";}";

    	customCSS += "#"+youmaxId+" .yl-description a, .yp-popup-description a, .yp-comment span {color: "+settings.headerBackgroundColor+";}";
    	customCSS += ".yp-share:hover, .yp-post-likes:hover, .yp-add-comment-button:hover {background-color: "+settings.headerBackgroundColor+"; box-shadow: 0px 0px 0px 1px "+settings.headerBackgroundColor+";}";

        customCSS += "#"+youmaxId+" .yl-play-fill-color{background-color:"+settings.headerBackgroundColor+";}";

    	//Title Color
    	customCSS += "#"+youmaxId+" .yl-title {color: "+settings.titleColor+";}";

    	
    	//customCSS += ".yl-tab-container{box-shadow: -0.2em 0px 0px 0px "+settings.viewsColor+";}";
    	

    	//Controld Text Color
    	customCSS += "#"+youmaxId+" .yl-list-title select, #"+youmaxId+" .yl-load-more-button, #"+youmaxId+" .yl-previous-button, #"+youmaxId+" .yl-next-button {color:"+settings.controlsTextColor+";}";
		
        //Tabs Color
        customCSS += "#"+youmaxId+" .yl-tab-container{color: "+settings.tabsColor+";}";

		//Offer Color
		customCSS += "#"+youmaxId+" .yl-callout-buy-button, #"+youmaxId+" .yl-callout-preview-button, #"+youmaxId+" .yl-offer-button{background-color:"+settings.offerHighlightColor+"; color:"+settings.offerBackgroundColor+";}";
    	customCSS += "#"+youmaxId+" .yl-callout, #"+youmaxId+" .yl-offer{box-shadow: 0px 0px 13px 2px rgba(0,0,0,0.2), 0.2em 0px 0px 0px "+settings.offerHighlightColor+";}";
    	customCSS += ".yl-grid-callouts .yl-callout{box-shadow: 0px 0px 13px 2px rgba(0,0,0,0.2);}";
    	customCSS += ".yl-callout-title,.yl-offer-title {color: "+settings.offerTextColor+";}";
		customCSS += ".yl-callout-description,.yl-offer-description {color:"+settings.offerTextColor+";}";
		customCSS += ".yl-callout-right,.yl-offer {background-color: "+settings.offerBackgroundColor+";}"


    	headerBackgroundColor = settings.headerBackgroundColor;
    	if(headerBackgroundColor.indexOf("rgb")!=-1) {
    		//convert rgb format to rgba format
    		lightHeaderColor = headerBackgroundColor.substring(0,headerBackgroundColor.length-1) + ",0.5)";
			lightHeaderColor = lightHeaderColor.replace("rgb","rgba");
			customCSS += ".yl-views-per-day{border-color: "+lightHeaderColor+";}";
			customCSS += "#"+youmaxId+" .yl-load-more-button:hover {background: linear-gradient(to right,"+lightHeaderColor+","+settings.itemBackgroundColor+" 20%);}"
			customCSS += "#"+youmaxId+" .yl-loading {background: "+lightHeaderColor+" !important;}";
    	}



    	//font size styles
    	customCSS += ".yl-title {font-size:"+settings.titleFontSize+"em !important; font-weight:"+settings.titleFontWeight+" !important;}";
    	customCSS += ".yl-description {font-size:"+settings.descriptionFontSize+"em !important;}";
    	customCSS += ".yl-date-bucket,.yl-view-string {font-size:"+settings.viewsDateFontSize+"em !important;}";
    	customCSS += ".youmax-pro,.mfp-container{font-size: "+settings.baseFontSize+";}";
    	
    	//offer font sizes
    	customCSS += ".yl-offer-title,.yl-callout-title {font-size:"+settings.offerTitleFontSize+"em !important;}";
    	customCSS += ".yl-offer-description, .yl-callout-description {font-size:"+settings.offerDescriptionFontSize+"em !important;}";
    	customCSS += ".yl-offer-button, .yl-callout-buy-button, .yl-callout-preview-button {font-size:"+settings.offerButtonFontSize+"em !important;}";

    	//font-family
    	customCSS += ".yl-item,.yl-callout,.yl-offer{font-family:"+settings.generalFontFamily+";}";
    	customCSS += ".yl-title,.yl-offer-title,.yl-callout-title {font-family:"+settings.titleFontFamily+";}";

    	//hiding options
    	if(settings.hideHeader) {
    		customCSS += "#"+youmaxId+" .yl-header {display:none;}";
    	}
    	if(settings.hideSearch) {
    		customCSS += "#"+youmaxId+" .yl-channel-search {display:none;}";
    	}    	
    	if(settings.hideTabs) {
    		customCSS += "#"+youmaxId+" .yl-tab-container {display:none;}";
    	}
    	if(settings.hideSorting) {
    		customCSS += "#"+youmaxId+" #yl-sort-order {display:none;}";
    	}
    	if(settings.hideViewSwitcher) {
    		customCSS += "#"+youmaxId+" .yl-switch {display:none;}";
    	}
    	if(settings.hideLoadingMechanism) {
    		customCSS += "#"+youmaxId+" .yl-load-more-button, #"+youmaxId+" .yl-previous-button, #"+youmaxId+" .yl-next-button{display:none;}";
    		customCSS += "#"+youmaxId+" .yl-cta-button{width:100%;}";
    	}
    	if(settings.hideCtaButton) {
    		customCSS += "#"+youmaxId+" .yl-cta-button{display:none;}";
    		customCSS += "#"+youmaxId+" .yl-load-more-button {width: 100%;} #"+youmaxId+" .yl-previous-button, #"+youmaxId+" .yl-next-button {width: 48.5%;}";
    	}
        if(settings.hidePopupDetails) {
            if(settings.videoDisplayMode=="inline") {
                customCSS += "#"+youmaxId+" .yp-popup-details {display:none;}";
            } else if(settings.videoDisplayMode=="popup") {
                customCSS += ".yp-popup-details {display:none;}";
                settings.popupAlignTop = false;
            }            
        }
        if(settings.hideDuration) {
            customCSS += "#"+youmaxId+" .yl-duration {display:none;}";
        }
        if(settings.hideThumbnailShadow) {
            customCSS += "#"+youmaxId+" .yl-item {box-shadow:none;}";
        }


    	//remove styles if already existing
    	$(".youmax-added-styles-"+youmaxId).remove();

    	//add new styles
		$("body").append("<style class='youmax-added-styles-"+youmaxId+"'>"+customCSS+"</style>");

    },

    clearSettings = function($youmaxPro){

    	var settings = $youmaxPro.data("settings");

    	settings.videoCache = [];
    	settings.nextPageToken = null;
    	settings.clearListOnDisplay = true;
    	settings.searchFlag = false;
    	settings.allDoneFlag = false;

    	$youmaxPro.data("settings",settings);

    },


    initHeader = function($youmaxPro){

    	var identifierJSON;
    	var settings = $youmaxPro.data("settings");

    	identifierJSON = sanitizeLink("youtube-channel-uploads",settings.channelLinkForHeader);

    	if(identifierJSON.identifier=="error") {
			return;
		}

		getChannelDetails(identifierJSON.identifierType,identifierJSON.identifier,null,$youmaxPro);
    
    },

    displayHeader = function(channelDetails,$youmaxPro){

    	var settings = $youmaxPro.data("settings");
    	var channelId = channelDetails.items[0].id;
    	var channelName = channelDetails.items[0].snippet.localized.title;
    	var channelLink = "//www.youtube.com/channel/"+channelId;
    	var channelThumbnail = channelDetails.items[0].snippet.thumbnails.default.url;

    	var $youmaxHeader = $youmaxPro.find(".yl-header");

    	var channelThumbnailHTML = "<div class='yl-channel-thumbnail'><a href='"+channelLink+"' target='_blank'><img src='"+channelThumbnail+"' /></a></div>";
    	var channelDetailsHTML = "<div class='yl-channel-details'><div class='yl-channel-name'><a href='"+channelLink+"' target='_blank'>"+channelName+"</a></div><div class='yl-subscribe'><div class='g-ytsubscribe' data-channelid='"+channelId+"' data-layout='default' data-count='default'></div></div></div>";
    	var channelSearchHTML = "<div class='yl-channel-search'><input class='yl-channel-search-input' type='text' placeholder='search' /><i class='fa fa-search'></i></div>";

    	$youmaxHeader.append(channelThumbnailHTML+channelDetailsHTML+channelSearchHTML);

    	settings.channelIdForSearch = channelId;

    	$youmaxPro.data("settings",settings);

		renderSubscribeButton();

    },

	
	//display youtube subscribe button
	renderSubscribeButton = function() {
	
		$.ajaxSetup({
		  cache: true
		});
		
		$.getScript("https://apis.google.com/js/platform.js")
		.done(function( script, textStatus ) {

		})
		.fail(function( jqxhr, settings, exception ) {

		});
		
	},
	


	createTabs = function($youmaxPro) {

		var identifierJSON,source,name,link,selected,channelId,channelUser,playlistId,tabId;
		var $youmaxTabContainer = $youmaxPro.find(".yl-tab-container");
		var settings = $youmaxPro.data("settings");

		for(var i=0; i<settings.tabs.length; i++) {

			source = settings.tabs[i].type;
			name = settings.tabs[i].name;
			link = settings.tabs[i].link;

			identifierJSON = sanitizeLink(source,link);

			//skip Tab in case of error
			if(identifierJSON.identifier=="error") {
				continue;
			}

			tabId = source + "-" + identifierJSON.identifier;
			$youmaxTabContainer.append("<div class='yl-tab' id='"+tabId+"'>"+name+"</div>");


			if(source=="youtube-channel-uploads") {

				//update the tab with uploads's playlist id
				getChannelDetails(identifierJSON.identifierType,identifierJSON.identifier,tabId,$youmaxPro);
					

			} else if(source=="youtube-channel-playlists") {

				if(identifierJSON.identifierType=="youtube-channel-user") {

					//update the tab with channel id
					getChannelDetails(identifierJSON.identifierType,identifierJSON.identifier,tabId,$youmaxPro);

				} else {

					//load videos if default Tab
					if(settings.defaultTab==name) {
						$youmaxPro.find("#"+tabId).click();
					}					

				}

			} else if(source=="youtube-playlist-videos") {
				
				//load videos if default Tab
				if(settings.defaultTab==name) {
					$youmaxPro.find("#"+tabId).click();
				}

			} else if(source=="vimeo-user-videos") {
				
				//load videos if default Tab
				if(settings.defaultTab==name) {
					$youmaxPro.find("#"+tabId).click();
				}

			}
			
		} //for loop on tabs ends

		
	},

	sanitizeLink = function(source,link) {

		var sanityIndex,channelId,channelUser,playlistId,userName;
		var identifierJSON = {
			identifier 			:"",
			identifierType		:""
		};

		//remove trailing slashes
		link = link.replace(/\/$/, "");
		//remove "/videos" from the end of URL
		link = link.replace("/videos","");
		//remove "/playlists" from the end of URL
		link = link.replace("/playlists","");


		if(source=="youtube-channel-uploads" || source=="youtube-channel-playlists") {

			sanityIndex = link.indexOf("/user/");
			if(sanityIndex==-1) {
				
				sanityIndex = link.indexOf("/channel/");

				if(sanityIndex==-1) {

					alert("\n\nChannel Link should be of the format: \nhttps://www.youtube.com/channel/UComP_epzeKzvBX156r6pm1Q \nOR\nhttps://www.youtube.com/user/designmilk\n\n");
					identifierJSON.identifierType = "youtube-channel-id";
					identifierJSON.identifier = "error";

				} else {

					channelId = link.substring(sanityIndex+9);
					identifierJSON.identifierType = "youtube-channel-id";
					identifierJSON.identifier = channelId;
					
				}

			} else {

				channelUser = link.substring(sanityIndex+6);
				identifierJSON.identifierType = "youtube-channel-user";				
				identifierJSON.identifier = channelUser;

			}


		} else if(source=="youtube-playlist-videos") {
			
			identifierJSON.identifierType = "youtube-playlist-id";

			sanityIndex = link.indexOf("list=");
			if(sanityIndex==-1) {
				alert("\n\nPlaylist Link should be of the format: \nhttps://www.youtube.com/playlist?list=PL6_h4dV9kuuIOBDKgxu3q9DpvvJFZ6fB5\n\n");
				identifierJSON.identifier = "error";
			} else {			
				playlistId = link.substring(sanityIndex+5);
				identifierJSON.identifier = playlistId;
			}
			

		} else if(source=="vimeo-user-videos") {

			identifierJSON.identifierType = "vimeo-user";

			sanityIndex = link.indexOf("vimeo.com/");
			if(sanityIndex==-1) {
				alert("\n\nVimeo User Link should be of the format: \nhttps://vimeo.com/user123\n\n");
				identifierJSON.identifier = "error";
			} else {			
				userName = link.substring(sanityIndex+10);
				identifierJSON.identifier = userName;
			}

		}

		return identifierJSON;



	},

	getChannelDetails = function(channelType,channelIdentifier,tabId,$youmaxPro) {

		var apiURL = "";
		var settings = $youmaxPro.data("settings");

		if(channelType=="youtube-channel-user") {
			apiURL = "https://www.googleapis.com/youtube/v3/channels?part=contentDetails%2Csnippet&forUsername="+channelIdentifier+"&key="+settings.apiKey;	
		} else if(channelType=="youtube-channel-id") { 
			apiURL = "https://www.googleapis.com/youtube/v3/channels?part=contentDetails%2Csnippet&id="+channelIdentifier+"&key="+settings.apiKey;	
		}
		

		$.ajax({
			url: apiURL,
			type: "GET",
			async: true,
			cache: true,
			dataType: 'json',
			success: function(response) {
				
				if(null==tabId) {
					displayHeader(response,$youmaxPro);
				} else {
					updateTabs(tabId,response,$youmaxPro);	
				}
				
			},
			error: function(html) { 
				
				
			}
		});

	},


	getChannelPlaylists = function(channelId,$youmaxPro) {

		var apiURL, videoArray, pageTokenUrl = "";
		var settings = $youmaxPro.data("settings");

		if(settings.nextPageToken!=null) {
			pageTokenUrl = "&pageToken="+settings.nextPageToken;
		}

		apiURL = "https://www.googleapis.com/youtube/v3/playlists?part=contentDetails%2Csnippet&channelId="+channelId+"&maxResults="+settings.maxResults+pageTokenUrl+"&key="+settings.apiKey;
			
		$.ajax({
			url: apiURL,
			type: "GET",
			async: true,
			cache: true,
			dataType: 'json',
			success: function(response) {
				videoArray = createPlaylistObjects(response.items,$youmaxPro);				
				handleToken("youtube",response.nextPageToken,$youmaxPro);
				displayItems(videoArray,$youmaxPro);
				if(settings.playlistNavigation) {
                    registerPlaylistNavigation($youmaxPro);
                } else {
                    videoDisplayMechanism($youmaxPro);    
                }
			},
			error: function(html) { 
				
				
			}
		});

	},

	getPlaylistVideos = function(playlistId,$youmaxPro) {
		
		var apiURL, pageTokenUrl = "";
		var settings = $youmaxPro.data("settings");

		if(settings.nextPageToken!=null) {
			pageTokenUrl = "&pageToken="+settings.nextPageToken;
		}

		apiURL = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&playlistId="+playlistId+"&maxResults="+settings.maxResults+pageTokenUrl+"&key="+settings.apiKey;


		$.ajax({
			url: apiURL,
			type: "GET",
			async: true,
			cache: true,
			dataType: 'json',
			success: function(response) {
				createVideoObjects(response.items,$youmaxPro);
				handleToken("youtube",response.nextPageToken,$youmaxPro);
			},
			error: function(html) { 
				
				
			}
		});			
	},

	getSearchVideos = function(searchText,$youmaxPro){

		var apiURL, pageTokenUrl = "";
		var settings = $youmaxPro.data("settings");

		if(settings.nextPageToken!=null) {
			pageTokenUrl = "&pageToken="+settings.nextPageToken;
		}


		apiURL = "https://www.googleapis.com/youtube/v3/search?part=snippet&q="+searchText+"&order=relevance&channelId="+settings.channelIdForSearch+"&type=video&maxResults="+settings.maxResults+pageTokenUrl+"&key="+settings.apiKey;


		$.ajax({
			url: apiURL,
			type: "GET",
			async: true,
			cache: true,
			dataType: 'json',
			success: function(response) {
				createSearchVideoObjects(response.items,$youmaxPro);
				handleToken("youtube",response.nextPageToken,$youmaxPro);
			},
			error: function(html) { 
				
				
			}
		});	

	},

	
	getVimeoUserVideos = function (userId,$youmaxPro) {

		var apiURL, pageTokenUrl = "";
		var videoArray;
		var settings = $youmaxPro.data("settings");

		if(settings.nextPageToken!=null) {
			pageTokenUrl = "&"+settings.nextPageToken;
		}

		apiURL = "https://api.vimeo.com/users/"+userId+"/videos?access_token="+settings.vimeoAccessToken+"&per_page="+settings.maxResults+pageTokenUrl;

		$.ajax({
			url: apiURL,
			type: "GET",
			async: true,
			cache: true,
			dataType: 'json',
			success: function(response) {
				videoArray = createVimeoVideoObjects(response.data,$youmaxPro);
				handleToken("vimeo",response.paging.next,$youmaxPro);
				displayItems(videoArray,$youmaxPro);
				videoDisplayMechanism($youmaxPro);
			},
			error: function(html) { 
				
				
			}
		});

	},

/*
	getYouTubeVideoLikes = function(videoId,$youmaxPro) {

		var apiURL, postArray;
		var settings = $youmaxPro.data("settings");

		apiURL = "https://www.googleapis.com/youtube/v3/commentThreads?part=id%2Csnippet&textFormat=plainText&videoId="+videoId+"&maxResults=6&key="+settings.apiKey+"&order=time";
		

		$.ajax({
			url: apiURL,
			type: "GET",
			async: true,
			cache: true,
			dataType: 'json',
			success: function(response) {
				displayYouTubeComments(response.items,$famaxPro);
			},
			error: function(html) { 
				
				
			}
		});

	},		
*/

	getYouTubeVideoComments = function(videoId,$youmaxPro) {

		var apiURL, postArray;
		var settings = $youmaxPro.data("settings");

		apiURL = "https://www.googleapis.com/youtube/v3/commentThreads?part=id%2Csnippet&textFormat=plainText&videoId="+videoId+"&maxResults=6&key="+settings.apiKey+"&order=time";
		

		$.ajax({
			url: apiURL,
			type: "GET",
			async: true,
			cache: true,
			dataType: 'json',
			success: function(response) {
				displayYouTubeComments(response.items,$youmaxPro);
			},
			error: function(html) { 
				
				
			}
		});

	},	



	handleToken = function(network,token,$youmaxPro) {

		var settings = $youmaxPro.data("settings");

		if(token==null) {
			showAllDoneButtonText($youmaxPro);
			settings.nextPageToken = null;
			$youmaxPro.data("settings",settings);
			return;
		}

		showOriginalButtonText($youmaxPro);

		//token is not null.. next page is present
		if(network=="vimeo") {
			token = token.substring(token.lastIndexOf("&")+1);	
			settings.nextPageToken = token;
		} else if(network="youtube") {
			settings.nextPageToken = token;	
		}

		$youmaxPro.data("settings",settings);

	},


	getVideoStatistics = function(videoIdArray,videoArray,$youmaxPro) {

		var settings = $youmaxPro.data("settings");
		var apiURL = "https://www.googleapis.com/youtube/v3/videos?part=statistics%2CcontentDetails%2Csnippet&id="+videoIdArray+"&key="+settings.apiKey;
		var videoArray;

		$.ajax({
			url: apiURL,
			type: "GET",
			async: true,
			cache: true,
			dataType: 'json',
			success: function(response) {
				videoArray = addStatisticsToVideos(response.items,videoArray,$youmaxPro);
				displayItems(videoArray,$youmaxPro);
				videoDisplayMechanism($youmaxPro);
			},
			error: function(html) { 
				
				
			}
		});			
	},


    createVideoObjects = function(itemArray,$youmaxPro) {

    	var videoIdArray = [], videoArray = [];
    	var proSnippet;

    	for(var i=0; i<itemArray.length; i++) {
    		proSnippet = new Object();
    		proSnippet.image = itemArray[i].snippet.thumbnails.medium.url;
    		proSnippet.title = itemArray[i].snippet.title;
    		proSnippet.description = itemArray[i].snippet.description;
    		proSnippet.playlistId = itemArray[i].snippet.playlistId;
    		proSnippet.videoId = itemArray[i].snippet.resourceId.videoId;
			proSnippet.link = "https://www.youtube.com/watch?v="+proSnippet.videoId+"&list="+proSnippet.playlistId;

			//TODO: Date will be added for uploads in next version
			//proSnippet.date = itemArray[i].snippet.publishedAt;
			//proSnippet.formattedDate = convertDate(proSnippet.date);
			
			videoArray.push(proSnippet);
			videoIdArray.push(proSnippet.videoId);
    	}

    	//get video stats
    	getVideoStatistics(videoIdArray,videoArray,$youmaxPro);    	

    },

    createVimeoVideoObjects = function(itemArray,$youmaxPro) {

    	var videoIdArray = [], videoArray = [];
    	var proSnippet;
    	var now = new Date().getTime();
		var views,viewsPerDay,duration;
		var settings = $youmaxPro.data("settings");

    	for(var i=0; i<itemArray.length; i++) {
    		proSnippet = new Object();
    		proSnippet.image = itemArray[i].pictures.sizes[2].link;
    		proSnippet.title = itemArray[i].name;
    		proSnippet.description = itemArray[i].description;
    		if(null==proSnippet.description) {
    			proSnippet.description = "";
    		}
			
			//link
			proSnippet.link = itemArray[i].link;
    		proSnippet.videoId = proSnippet.link.substring(proSnippet.link.indexOf("/",15)+1);

			//views
			views = itemArray[i].stats.plays;
			proSnippet.views = views;
    		
    		//date
    		proSnippet.date = itemArray[i].release_time;
			proSnippet.formattedDate = convertDate(proSnippet.date);

			//calculate view per day to define trend
			viewsPerDay = (views)/((now - new Date(proSnippet.date).getTime())/1000/60/60/24);
			proSnippet.viewsPerDay = viewsPerDay;
			
			//convert views
			views = convertViews(views);
			proSnippet.commaSeparatedViews = views;

			//duration
			duration = convertVimeoDuration(itemArray[i].duration);
			proSnippet.duration = duration;
			
			videoArray.push(proSnippet);
    	}  	

		settings.currentCacheBlockStart = settings.videoCache.length;
    	settings.videoCache = settings.videoCache.concat(videoArray);
    	settings.currentCacheBlockEnd = settings.videoCache.length;

    	$youmaxPro.data("settings",settings);

    	return videoArray;

    },


    createSearchVideoObjects = function(itemArray,$youmaxPro) {

    	var videoIdArray = [], videoArray = [];
    	var proSnippet;

    	for(var i=0; i<itemArray.length; i++) {
    		proSnippet = new Object();
    		proSnippet.image = itemArray[i].snippet.thumbnails.medium.url;
    		proSnippet.title = itemArray[i].snippet.title;
    		proSnippet.description = itemArray[i].snippet.description;
    		proSnippet.playlistId = null;
    		proSnippet.videoId = itemArray[i].id.videoId;
			proSnippet.link = "//www.youtube.com/watch?v="+proSnippet.videoId;

			//TODO: Date will be added for uploads in next version
			//proSnippet.date = itemArray[i].snippet.publishedAt;
			//proSnippet.formattedDate = convertDate(proSnippet.date);
			
			videoArray.push(proSnippet);
			videoIdArray.push(proSnippet.videoId);
    	}

    	//get video stats
    	getVideoStatistics(videoIdArray,videoArray,$youmaxPro);    	

    },


    createPlaylistObjects = function(itemArray,$youmaxPro) {

    	var videoIdArray = [], videoArray = [];
    	var proSnippet;
    	var settings = $youmaxPro.data("settings");

    	for(var i=0; i<itemArray.length; i++) {
    		proSnippet = new Object();
    		proSnippet.isPlaylist = true;
    		proSnippet.image = itemArray[i].snippet.thumbnails.medium.url;
    		proSnippet.title = itemArray[i].snippet.title;
    		proSnippet.description = itemArray[i].snippet.description;
    		proSnippet.playlistId = itemArray[i].id;
    		proSnippet.videoId = itemArray[i].id;
			proSnippet.link = "//www.youtube.com/playlist?list="+proSnippet.playlistId;

			
			proSnippet.date = itemArray[i].snippet.publishedAt;
			proSnippet.formattedDate = convertDate(proSnippet.date);

			//adding number of videos in a playlist inside the "commaSeparatedViews" variable
			proSnippet.itemCount = itemArray[i].contentDetails.itemCount;
			if(itemArray[i].contentDetails.itemCount <= 0) {
				//skip the playlist with 0 videos
				continue;
			}

			proSnippet.viewsPerDay = 0;
			
			videoArray.push(proSnippet);
			videoIdArray.push(proSnippet.videoId);
    	}

		settings.currentCacheBlockStart = settings.videoCache.length;
    	settings.videoCache = settings.videoCache.concat(videoArray);
    	settings.currentCacheBlockEnd = settings.videoCache.length;

		$youmaxPro.data("settings",settings);

    	return videoArray;	

    },



    addStatisticsToVideos = function(statisticArray,videoArray,$youmaxPro) {

		var now = new Date().getTime();
		var views,viewsPerDay,duration;
		var settings = $youmaxPro.data("settings");


    	for(var i=0; i<statisticArray.length; i++) {
    		views = statisticArray[i].statistics.viewCount;
			videoArray[i].views = views;
    		videoArray[i].date = statisticArray[i].snippet.publishedAt;
			videoArray[i].formattedDate = convertDate(videoArray[i].date);

			//likes & comments
			videoArray[i].likes = statisticArray[i].statistics.likeCount;
			videoArray[i].commaSeparatedLikes = convertViews(statisticArray[i].statistics.likeCount);
			videoArray[i].comments = statisticArray[i].statistics.commentCount;
			videoArray[i].commaSeparatedComments = convertViews(statisticArray[i].statistics.commentCount);

			//calculate view per day to define trend
			viewsPerDay = (views)/((now - new Date(videoArray[i].date).getTime())/1000/60/60/24);
			videoArray[i].viewsPerDay = viewsPerDay;
			
			//convert views
			views = convertViews(views);
			videoArray[i].commaSeparatedViews = views;

			duration = convertDuration(statisticArray[i].contentDetails.duration);
			videoArray[i].duration = duration;


    	}

    	settings.currentCacheBlockStart = settings.videoCache.length;
    	settings.videoCache = settings.videoCache.concat(videoArray);
    	settings.currentCacheBlockEnd = settings.videoCache.length;

    	$youmaxPro.data("settings",settings);

    	return videoArray;

    },

    updateTabs = function(tabId,channelDetails,$youmaxPro){

    	var $youmaxTab = $youmaxPro.find("#"+tabId);
    	var uploadsPlaylistId = channelDetails.items[0].contentDetails.relatedPlaylists.uploads;
    	var channelId = channelDetails.items[0].id;
    	var finalTabId;
    	var settings = $youmaxPro.data("settings");

    	if(tabId.indexOf("youtube-channel-uploads")!=-1) {
    		finalTabId = "youtube-channel-uploads-"+uploadsPlaylistId;
    		$youmaxTab.attr("id",finalTabId);
    	} else if(tabId.indexOf("youtube-channel-playlists")!=-1) {
    		finalTabId = "youtube-channel-playlists-"+channelId;
    		$youmaxTab.attr("id",finalTabId);
    	}

    	if(settings.defaultTab==$youmaxTab.text()) {
			$youmaxPro.find("#"+finalTabId).click();
		}

    },


	displayItems = function(videoArray,$youmaxPro) {

		var viewboxHTML, dateboxHTML, trendBoxHTML, itemboxHTML, durationHTML, viewStringHTML, sortOrder, containerHTML="", playlistHTML = "", hoverPlayHTML, fixedPlayHTML;
		var image, views, viewsPerDay, title, description, date, link, id, popupLink, duration, viewsText, isPlaylist, itemCount, likes, comments;
		var sortOrder = $youmaxPro.find("#yl-sort-order").val();
		var $youmaxContainer = $youmaxPro.find(".yl-item-container");
		var settings = $youmaxPro.data("settings");
		var list = videoArray;		
		//list = settings.videoCache
		
		if(settings.searchFlag) {
			sortOrder = "relevenace";
			//do not sort when user searches
		}

		if(sortOrder=="popular-first") {
			list.sort(popularFirstComparator);
		} else if(sortOrder=="recent-first") {
			list.sort(latestFirstComparator);
		}

		if(settings.clearListOnDisplay) {
			clearList($youmaxPro);
		}

		for(var count=0; count<list.length; count++) {	
			
            image = list[count].image;
			views = list[count].commaSeparatedViews;
			viewsPerDay = list[count].viewsPerDay;
			title = list[count].title;
			description = list[count].description;
			date = list[count].formattedDate;
            link = list[count].link;
            id = list[count].videoId;
            popupLink = "//www.youtube.com/watch?v="+id;
            duration = list[count].duration;            
            isPlaylist = list[count].isPlaylist;
            itemCount = list[count].itemCount;

            likes = list[count].commaSeparatedLikes;
            comments = list[count].commaSeparatedComments;

            description = processDescription(description);

            hoverPlayHTML = "<div class='yl-play-overlay'></div>";
            fixedPlayHTML = "<div class='yl-play-overlay-fixed'><div class='yl-play-icon-holder'><i class='fa fa-play'></i></div></div>";
            //<div class='yl-play-icon-holder'><i class='fa fa-play'></i><span>"+duration+"</span></div>

            if(isPlaylist) {
            	viewsText = itemCount + " <span>videos</span>";
            	playlistHTML = "<div class='yl-playlist-video-count-wrapper'><div class='yl-playlist-video-count-box'><span class='yl-playlist-video-count'>"+itemCount+"</span><br>VIDEOS<br><div class='yl-playlist-line-wrapper'><span class='yl-playlist-line'></span><br><span class='yl-playlist-line'></span><br><span class='yl-playlist-line'></span></div></div></div>";
            	hoverPlayHTML = "";
                fixedPlayHTML = "";
            } else {
            	viewsText = views + " <span>views</span>";
            }

			if(viewsPerDay>settings.minimumViewsPerDayForTrendingVideos) {
				trendBoxHTML = "<div class='yl-views-per-day'><i class='fa fa-bolt'></i></div>";
			} else {
				trendBoxHTML = "";
			}

			if(null!=duration) {
				durationHTML = "<div class='yl-duration'><i class='fa fa-play'></i>"+duration+"</div>";
			} else {
				durationHTML = "";
			}

			//viewboxHTML = "<div class='yl-view-bucket' data-views='"+views+"'><div class='yl-view-wrapper'><div class='yl-view-icon'><div class='triangle-with-shadow'></div></div><div class='yl-view-count'>"+viewsFancy+"</div></div></div>";

			viewboxHTML = "<div class='yl-view-bucket' data-views='"+views+"'><div class='yl-view-wrapper'><div class='yl-view-count'>"+viewsText+"</div></div></div>";


			viewStringHTML = "<div class='yl-view-string'>"+viewsText+"</div>";
		
			dateboxHTML = "<div class='yl-date-bucket'>"+date+"</div>";

			itemboxHTML = "<div class='yl-item' id='"+id+"' data-likes='"+likes+"' data-comments='"+comments+"'><div class='yl-focus' href='"+popupLink+"' data-link='"+link+"'><div class='yl-thumbnail'><img src='"+image+"''>"+durationHTML+hoverPlayHTML+fixedPlayHTML+"</div><br/>"+viewboxHTML+"</div><div class='yl-text'><div class='yl-title-description-wrapper'><div class='yl-title'>"+title+"</div><div class='yl-description'>"+description+"</div></div>"+"<div class='yl-separator-for-grid'></div>"+viewStringHTML+dateboxHTML+trendBoxHTML+"</div>"+playlistHTML+"</div>";

			containerHTML += "<div class='yl-item-wrapper'>"+itemboxHTML+"</div>";

		}

        if(isPlaylist) {
            $("body").addClass("yl-playlist");
        } else {
            $("body").removeClass("yl-playlist");
        }

		$youmaxContainer.append(containerHTML);

	},

	displayPopupData = function($baseElement,$youmaxPro) {

		var popupTitleHTML,popupDescriptionHTML,popupMoreHTML,facebookShareHTML,twitterShareHTML,googleShareHTML;
		var youtubeLikesHTML, youtubeAddCommentHTML, youtubeCommentsHTML, youtubeCommentListHTML;
		var videoId, title, textTitle, description, link, likes,comments;
		var $popupBox;

		setTimeout(function(){

			$popupBox = $(".yp-popup-details");

			videoId = $baseElement.attr("id");
			title = $baseElement.find(".yl-title").html();
			textTitle = $baseElement.find(".yl-title").text();
			description = $baseElement.find(".yl-description").html();
			description = description.replace(/\n/g,"<br>");
			link = $baseElement.find(".yl-focus").data("link");
			link = encodeURIComponent(link);

			likes = $baseElement.data("likes");
			comments = $baseElement.data("comments");

			popupTitleHTML = "<div class='yp-popup-title'>"+title+"</div>";
			popupDescriptionHTML = "<div class='yp-popup-description yp-show-less'>"+description+"</div>";
			popupMoreHTML = "<div class='yp-popup-more-button'>show more..</div><br>";
			facebookShareHTML = "<div onclick=\"window.open('https://www.facebook.com/sharer.php?u="+link+"','facebook','width=500,height=350');\" class='yp-share'><i class='fa fa-facebook'></i></div>";
			twitterShareHTML = "<div onclick=\"window.open('https://twitter.com/share?text="+textTitle+"&url="+link+"','facebook','width=500,height=350');\" class='yp-share'><i class='fa fa-twitter'></i></div>";
			googleShareHTML = "<div onclick=\"window.open('https://plus.google.com/share?url="+link+"','facebook','width=500,height=350');\" class='yp-share'><i class='fa fa-google'></i></div>";


			youtubeLikesHTML = "<div class='yp-post-like-box'><div class='yp-post-like-count'>"+likes+"<br><span>likes</span></div><div class='yp-post-likes' title='Add a YouTube Like' data-videoid='"+videoId+"'><div class='yp-add-like-icon'><i class='fa fa-thumbs-up'></i><i class='fa fa-youtube'></i></div></div></div>";
			youtubeAddCommentHTML = "<div class='yp-add-comment-box'><input type='text' id='yp-add-comment-text' placeholder='Write a YouTube comment..' /><div class='yp-add-comment-button'><i class='fa fa-youtube'></i>Post</div></div>";
			youtubeCommentListHTML = "<div class='yp-post-comment-box'><div class='yp-post-comments'></div></div>";
			youtubeCommentsHTML = "<div class='yp-post-comment-snap'><div class='yp-post-comment-count'>"+comments+"<br><span>comments</span></div><div class='yp-post-comment-users'></div></div>";

			//<a target='_blank' href='https://www.facebook.com/sharer.php?u="+link+"'>
			$popupBox.empty();

			$popupBox.append("<div class='yp-right-section'>"+popupTitleHTML+popupDescriptionHTML+popupMoreHTML+youtubeLikesHTML+youtubeAddCommentHTML+youtubeCommentsHTML+youtubeCommentListHTML+"</div>"+"<div class='yp-left-section'>"+facebookShareHTML+twitterShareHTML+googleShareHTML+"</div>");

			getYouTubeVideoComments(videoId,$youmaxPro);


		}, 100);
		
	},


	displayYouTubeComments = function(commentArray,$youmaxPro) {

		for(var i=0; i<commentArray.length; i++) {

			$(".yp-post-comments").append("<div class='yp-comment'><div class='yp-comment-img'><img class='yp-comment-from-img' src='"+commentArray[i].snippet.topLevelComment.snippet.authorProfileImageUrl+"' /></div><div class='yp-comment-text'><span>"+commentArray[i].snippet.topLevelComment.snippet.authorDisplayName+"</span><br> "+commentArray[i].snippet.topLevelComment.snippet.textDisplay+"</div></div>");

			$(".yp-post-comment-users").append("<img src='"+commentArray[i].snippet.topLevelComment.snippet.authorProfileImageUrl+"' />");

		}

	},

	clearList = function($youmaxPro) {
		$youmaxPro.find(".yl-item-container").empty();
	},

    videoDisplayMechanism = function($youmaxPro){

    	var settings = $youmaxPro.data("settings");

    	if(settings.videoDisplayMode=="popup") {
			registerPopup($youmaxPro);	
		} else if(settings.videoDisplayMode=="inline") {
			registerInlineEmbed($youmaxPro);	
		} else {
			registerLinkToYouTube($youmaxPro);
		}

    },

    registerPopup = function($youmaxPro) {

    	var currentTabId, playlistId, embedURL = "";
    	var settings = $youmaxPro.data("settings");
    	var autoPlayString = settings.autoPlay ? "&autoplay=1" : "&autoplay=0";

    	//get selected tab and handle the tab click
		currentTabId = $youmaxPro.find(".yl-selected-tab").attr("id");
		playlistId = currentTabId.substring(currentTabId.indexOf("-",20)+1);

    	if(currentTabId.indexOf("vimeo")!=-1) {
    		embedURL = "//player.vimeo.com/video/%id%?badge=0&autopause=0&player_id=0"+autoPlayString;
    	} else if(currentTabId.indexOf("youtube-channel-playlists")!=-1) {
    		embedURL = "//www.youtube.com/embed?listType=playlist&list=%id%&rel=0"+autoPlayString;
    	} else {
    		embedURL = "//www.youtube.com/embed/%id%?&rel=0"+autoPlayString;
    	}

    	$youmaxPro.find(".yl-focus").magnificPopup({
    		gallery: {
		      enabled: true
		    },
    		type:'iframe',
    		iframe:{
    			
    			markup:
    				'<div class="mfp-iframe-scaler">'+
						'<button title="Close (Esc)" type="button" class="mfp-close">×</button>'+
						'<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>'+
						'<div class="yp-popup-details"></div>'+
					'</div>'+
					'<div class="mfp-preloader">Loading...</div>',

    			patterns: {
					youtube: {
						src: embedURL
					},
					vimeo : {
						src: embedURL
					}
				}
    		},

    		alignTop: settings.popupAlignTop,
    		
    		callbacks: {
				change: function() {
						
					// Triggers each time when content of popup changes
					var $baseElement = $(this.currItem.el[0].offsetParent);
					displayPopupData($baseElement,$youmaxPro);
					
				}			
			}
    	});

    },

	registerInlineEmbed = function($youmaxPro) {

		//get selected tab and handle the tab click
		var currentTabId = $youmaxPro.find(".yl-selected-tab").attr("id");
		var playlistId = currentTabId.substring(currentTabId.indexOf("-",20)+1);
		var settings = $youmaxPro.data("settings");

    	$youmaxPro.on("click",".yl-focus", function(){

	    	var embedURL = "";
	    	var id = $(this).parents(".yl-item").attr("id");
	    	var $youmaxInlineContainer = $youmaxPro.find(".yl-inline-container");
	    	
	    	var autoPlayString = settings.autoPlay ? "&autoplay=1" : "&autoplay=0";
	    	var videoContainerHTML, videoDataHTML;

	    	if(currentTabId.indexOf("vimeo")!=-1) {
    			embedURL = "//player.vimeo.com/video/"+id+"?badge=0&autopause=0&player_id=0"+autoPlayString;
    		} else if(currentTabId.indexOf("youtube-channel-playlists")!=-1) {
	    		embedURL = "//www.youtube.com/embed?listType=playlist&list="+id+"&rel=0"+autoPlayString;
	    	} else {
	    		embedURL = "//www.youtube.com/embed/"+id+"?rel=0"+autoPlayString;
	    	}

	    	videoContainerHTML = '<div class="fluid-width-video-wrapper" style="padding-top:'+(settings.aspectRatio*100)+'%;"><iframe class="yl-inline-iframe" src="'+embedURL+'" frameborder="0" allowfullscreen></iframe></div>';

	    	videoDataHTML = '<div class="yp-popup-details yp-inline-popup"></div>';

    		$youmaxInlineContainer.html(videoContainerHTML+videoDataHTML).css("display","inline-block");

    		$('html, body').animate({scrollTop: $youmaxInlineContainer.offset().top - 150},'slow');

    		var $baseElement = $(this).parent(".yl-item");
    		displayPopupData($baseElement,$youmaxPro);

    	});

    	if(settings.displayFirstVideoOnLoad) {
    		$youmaxPro.find(".yl-focus:first").click();
    	}

    },

    registerLinkToYouTube = function($youmaxPro) {

    	$youmaxPro.find(".yl-focus").each(function(i,v){
    		var $focusElement = $(v);
    		var link = $focusElement.data("link");
    		$focusElement.wrap("<a href='"+link+"' target='_blank'></a>");
    	});

    },

    registerPlaylistNavigation = function($youmaxPro) {

        $youmaxPro.find(".yl-focus").click(function(){
            var $item = $(this).parent(".yl-item");
            var playlistId = $item.attr("id");
            var playlistTitle = $item.find(".yl-title").text();
            var settings = $youmaxPro.data("settings");
            var $currentTab = $youmaxPro.find(".yl-selected-tab");
            var $playlistTab = $youmaxPro.find(".yl-showing-playlist-name");

            //remove selected tab
            $currentTab.removeClass("yl-selected-tab");

            //set last tab id
            settings.previousTabId = $currentTab.attr("id");
            $youmaxPro.data("settings",settings);

            //set playlist name
            $playlistTab.data("playlist-name",playlistTitle).attr("id","youtube-playlist-videos-"+playlistId).addClass("yl-playlist-tab");

            handlePlaylistTabClick($playlistTab,$youmaxPro);

        });

    },

	popularFirstComparator = function(a,b) {
		return b.views - a.views;
	},

	latestFirstComparator = function(a,b) {
		return (new Date(b.date).getTime()) - (new Date(a.date).getTime());
	},	

	handleSortOrders = function($youmaxPro) {
		
		var seenVideos = [];
		var settings = $youmaxPro.data("settings");
		
		$('#yl-sort-order').change(function() {
	        seenVideos = saveSeenVideos($youmaxPro);
			showLoader($youmaxPro);
			//not needed as list is cleared in show loader
			//clearList($youmaxPro);

			//remove search flag as sorting needs to be done
			settings.searchFlag = false;
			
			displayItems(settings.videoCache,$youmaxPro);
	        highlightSeenVideos(seenVideos,$youmaxPro);
			videoDisplayMechanism($youmaxPro);
		});

		$youmaxPro.find("#yl-sort-order").val(settings.defaultSortOrder);
	
	},

	handleGridListSwitch = function ($youmaxPro) {

		var $viewSwitch = $youmaxPro.find(".yl-switch");
		var requiredView;
		var settings = $youmaxPro.data("settings");

		if(settings.youmaxDisplayMode=="grid") {
			$viewSwitch.find("i").addClass("fa-bars").removeClass("fa-th-large")
			$viewSwitch.data("view","double-list");
		} else {
			$viewSwitch.find("i").removeClass("fa-bars").addClass("fa-th-large")
			$viewSwitch.data("view","grid");
		}

		$viewSwitch.click(function(){

			requiredView = $viewSwitch.data("view");
			settings.youmaxDisplayMode = requiredView;
			$youmaxPro.removeClass("yl-double-list yl-list yl-grid yl-1-col-grid yl-2-col-grid yl-3-col-grid yl-4-col-grid yl-5-col-grid");
			handleYoumaxDisplay($youmaxPro);
			
			if(requiredView=="double-list") {
				$viewSwitch.find("i").removeClass("fa-bars").addClass("fa-th-large")
				$viewSwitch.data("view","grid");
			} else {
				$viewSwitch.find("i").addClass("fa-bars").removeClass("fa-th-large")
				$viewSwitch.data("view","double-list");
			}

		});

	},

	handleTabs = function ($youmaxPro) {

		$youmaxPro.on("click",".yl-tab",function() {

            handleTabClick($(this),$youmaxPro);
		
        });

        $youmaxPro.on("click",".yl-playlist-tab",function() {

            //go back to last tab
            var settings = $youmaxPro.data("settings");
            var previousTabId = settings.previousTabId;
            $youmaxPro.find("#"+previousTabId).click();
        
        });

	},


    handleTabClick = function($tab,$youmaxPro) {

        clearSettings($youmaxPro);
        showLoader($youmaxPro);

        //add selected tab class to current tab
        $youmaxPro.find(".yl-tab").removeClass("yl-selected-tab");
        $tab.addClass("yl-selected-tab");

        displayTabItems($youmaxPro);

    },


    handlePlaylistTabClick = function($tab,$youmaxPro) {

        var settings = $youmaxPro.data("settings");
        var playlistName;

        clearSettings($youmaxPro);
        showLoader($youmaxPro);

        //add selected tab class to current tab
        $youmaxPro.find(".yl-tab").removeClass("yl-selected-tab");
        $tab.addClass("yl-selected-tab");

        playlistName = $tab.data("playlist-name");
        $tab.append("<i class='fa fa-chevron-left'></i> Showing playlist: "+playlistName).show();

        displayTabItems($youmaxPro);

    },

    displayTabItems = function($youmaxPro) {

    	//get selected tab and handle the tab click
		var tabId = $youmaxPro.find(".yl-selected-tab").attr("id");
    	var identifier = tabId.substring(tabId.indexOf("-",17)+1);

    	if(tabId.indexOf("youtube-channel-uploads")!=-1) {
    		getPlaylistVideos(identifier,$youmaxPro);
    	} else if(tabId.indexOf("youtube-channel-playlists")!=-1) {
    		getChannelPlaylists(identifier,$youmaxPro);
    	} else if(tabId.indexOf("youtube-playlist-videos")!=-1) {
    		getPlaylistVideos(identifier,$youmaxPro);
    	} else if(tabId.indexOf("vimeo-user-videos")!=-1) {
    		getVimeoUserVideos(identifier,$youmaxPro);
    	} 

    },

    handleSearch = function($youmaxPro) {

    	var searchText;

    	$youmaxPro.on('keyup','.yl-channel-search-input', function (e) {
			if (e.keyCode == 13) {
			
				clearSettings($youmaxPro);	    		
	    		showLoader($youmaxPro);
				displaySearchItems($youmaxPro);
				
				return false;
			}
		});

    },

    displaySearchItems = function($youmaxPro) {

    	var searchText;
        var settings = $youmaxPro.data("settings");

		//set search flag as sorting needs to be doen on relevance
		settings.searchFlag = true;
		$youmaxPro.data("settings",settings);

		searchText = $youmaxPro.find('.yl-channel-search-input').val().replace(/ /g,"%20");
    	getSearchVideos(searchText,$youmaxPro);

    },


	handlePopupButtons = function($youmaxPro) {

		/*$youmaxPro.on("mouseenter",".yl-focus",function() {
			$(this).find(".triangle-with-shadow").addClass("triangle-with-hover");
		});

		$youmaxPro.on("mouseleave",".yl-focus",function() {
			$(this).find(".triangle-with-shadow").removeClass("triangle-with-hover");
		});

		$youmaxPro.on("click",".yl-focus",function() {
			$(this).find(".yl-view-bucket").addClass("yl-view-bucket-seen");
			$(this).find(".triangle-with-shadow").removeClass("triangle-with-hover");
		});*/

		$("body").on("click",".yp-popup-more-button",function() {
			$(this).remove();
			$(".yp-show-less").removeClass("yp-show-less");
		});

		$(document).on("click", ".yp-post-likes", function(){
			handleYouTubeLikes($youmaxPro);
		});

		$(document).on("click", ".yp-add-comment-button", function(){
			handleYouTubeComments($youmaxPro);
		});
		

	},

	handleAnimations = function($youmaxPro) {

		var settings = $youmaxPro.data("settings");
        var customCSS;
        var youmaxId = $youmaxPro.attr("id");

        if(settings.showFixedPlayIcon) {
            customCSS = "#"+youmaxId+" .yl-duration i{display:none;}"
            customCSS += "#"+youmaxId+" .yl-play-overlay-fixed {display: block;}";
            
            //square or circle
            if(settings.iconShape=="circle") {
                customCSS += "#"+youmaxId+" .yl-play-icon-holder {width: 2.6em;height: 2.6em;border-radius: 100%;padding: 0.1em 0.25em;box-sizing: border-box;}";
            }

            $("body").append("<style class='youmax-added-styles-"+youmaxId+"'>"+customCSS+"</style>");

            if(settings.showHoverAnimation) {
                $youmaxPro.on("mouseenter",".yl-focus",function() {
                    $(this).find(".yl-play-icon-holder").addClass("yl-play-fill-color");
                });

                $youmaxPro.on("mouseleave",".yl-focus",function() {
                    $(this).find(".yl-play-icon-holder").removeClass("yl-play-fill-color");
                });         
            }

        } else if(settings.showHoverAnimation) {
			$youmaxPro.on("mouseenter",".yl-focus",function() {
				$(this).find(".yl-duration").addClass("yl-duration-big");
				$(this).find(".yl-play-overlay").show();
			});

			$youmaxPro.on("mouseleave",".yl-focus",function() {
				$(this).find(".yl-duration").removeClass("yl-duration-big");
				$(this).find(".yl-play-overlay").hide();
			});			
		}

        

	},


	handleLoadingMechanism = function($youmaxPro) {

		var settings = $youmaxPro.data("settings");

		//Load More button handler
		$youmaxPro.on('click','.yl-load-more-button', function(){

			//remove first video auto load flag
			settings.displayFirstVideoOnLoad = false;

			if(settings.allDoneFlag) {
				return;
			}
			
			$(this).addClass("yl-loading").html(settings.loadingText);

			//do not clear list during load mores
			settings.clearListOnDisplay = false;
			$youmaxPro.data("settings",settings);

			checkCache("next",$youmaxPro);

		});

		//Next Button Handler
		$youmaxPro.on('click','.yl-next-button', function(){

			//remove first video auto load flag
			settings.displayFirstVideoOnLoad = false;

			//cannot use alldone flag for prev-next buttons
			/*if(settings.allDoneFlag) {
				return;
			}*/
			$(this).addClass("yl-loading").html(settings.loadingText);

			//Clear list during load mores
			settings.clearListOnDisplay = true;

			//fade out the current items
			$youmaxPro.find(".yl-item").addClass("yl-fading");
			$youmaxPro.data("settings",settings);

			checkCache("next",$youmaxPro);

		});

		//Previous Button Handler
		$youmaxPro.on('click','.yl-previous-button', function(){

			//remove first video auto load flag
			settings.displayFirstVideoOnLoad = false;

			//cannot use alldone flag for prev-next buttons
			/*if(settings.allDoneFlag) {
				return;
			}*/
			$(this).addClass("yl-loading").html(settings.loadingText);

			//fade out the current items
			$youmaxPro.find(".yl-item").addClass("yl-fading");

			//Clear list during load mores
			settings.clearListOnDisplay = true;
			$youmaxPro.data("settings",settings);

			checkCache("previous",$youmaxPro);

		});


	},

	checkCache = function(direction,$youmaxPro) {

		var newCacheBlockStart, newCacheBlockEnd, videoArray, maxResults;
		var settings = $youmaxPro.data("settings");

		maxResults = parseInt(settings.maxResults,10);

		if(direction=="previous") {

			//for previous navigation
			newCacheBlockStart = settings.currentCacheBlockStart - maxResults;
			newCacheBlockEnd = settings.currentCacheBlockStart;

			
			if(newCacheBlockStart<0) {
				newCacheBlockStart = 0;
			}

			if(newCacheBlockEnd<=0) {
				showAllDoneButtonText($youmaxPro);
				return;
			}

		
		} else if(direction=="next") {

			//for next navigation
			newCacheBlockStart = settings.currentCacheBlockEnd;
			newCacheBlockEnd = newCacheBlockStart + maxResults;

			if(newCacheBlockEnd>settings.videoCache.length) {
				newCacheBlockEnd = settings.videoCache.length;
			}

			if(newCacheBlockStart>=settings.videoCache.length) {
				showMoreVideosHandler($youmaxPro);
				return;
			}			

		}

		settings.currentCacheBlockStart = newCacheBlockStart;
		settings.currentCacheBlockEnd = newCacheBlockEnd;
		$youmaxPro.data("settings",settings);

		videoArray = settings.videoCache.slice(newCacheBlockStart, newCacheBlockEnd);
		displayItems(videoArray,$youmaxPro);

		showOriginalButtonText($youmaxPro);

	},


	showOriginalButtonText = function($youmaxPro) {

		var originalText;

		var $nextButton = $youmaxPro.find(".yl-next-button");
		var $previousButton = $youmaxPro.find(".yl-previous-button");
		var $loadMoreButton = $youmaxPro.find(".yl-load-more-button");
		
		originalText = $nextButton.data("text");
		$nextButton.removeClass("yl-loading").html(originalText);

		originalText = $previousButton.data("text");
		$previousButton.removeClass("yl-loading").html(originalText);

		originalText = $loadMoreButton.data("text");
		$loadMoreButton.removeClass("yl-loading").html(originalText);

	},

	showAllDoneButtonText = function($youmaxPro) {

		var $loadingButton = $youmaxPro.find(".yl-loading");
		var settings = $youmaxPro.data("settings");

		if(null==$loadingButton || $loadingButton.length==0) {
			if(settings.loadingMechanism=="load-more") {
				$loadingButton = $youmaxPro.find(".yl-load-more-button");
			} else {
				$loadingButton = $youmaxPro.find(".yl-next-button");
			}
		}

		$loadingButton.removeClass("yl-loading").html(settings.allDoneText);
		settings.allDoneFlag = true;
		$youmaxPro.data("settings",settings);

		//remove fading for pagination
		$youmaxPro.find(".yl-item").removeClass("yl-fading");
		
	},


	showMoreVideosHandler = function($youmaxPro) {

		var settings = $youmaxPro.data("settings");

		//do nothing if next token is not present
		if(settings.nextPageToken==null) {
			showAllDoneButtonText($youmaxPro);
			settings.nextPageToken = null;
			$youmaxPro.data("settings",settings);
			return;
		}

		if(settings.searchFlag) {
			displaySearchItems($youmaxPro);
		} else {
			displayTabItems($youmaxPro);	
		}

	},

	handleYoumaxDisplay = function($youmaxPro) {

		var settings = $youmaxPro.data("settings");

		if(settings.youmaxDisplayMode=="double-list") {
			if($youmaxPro.width()<settings.responsiveBreakpoints[0]) {
				$youmaxPro.addClass("yl-grid").removeClass("yl-double-list").removeClass("yl-list");
			}  else if($youmaxPro.width()<settings.responsiveBreakpoints[1]) {
				$youmaxPro.removeClass("yl-double-list").removeClass("yl-grid").addClass("yl-list");
			} else if($youmaxPro.width()>=settings.responsiveBreakpoints[1]) {
	    		$youmaxPro.addClass("yl-double-list").removeClass("yl-grid").removeClass("yl-list");
	    	}  
		}

		if(settings.youmaxDisplayMode=="list") {
			if($youmaxPro.width()<settings.responsiveBreakpoints[0]) {
				$youmaxPro.addClass("yl-grid").removeClass("yl-list");
			} else {
				$youmaxPro.removeClass("yl-grid").addClass("yl-list");
			}
		}

		if(settings.youmaxDisplayMode=="grid") {
    		$youmaxPro.addClass("yl-grid");
    		if($youmaxPro.width()<settings.responsiveBreakpoints[0]) {
    			$youmaxPro.addClass("yl-1-col-grid").removeClass("yl-2-col-grid yl-3-col-grid yl-4-col-grid yl-4-col-grid");
    		} else if($youmaxPro.width()<settings.responsiveBreakpoints[1]) {
    			$youmaxPro.addClass("yl-2-col-grid").removeClass("yl-1-col-grid yl-3-col-grid yl-4-col-grid yl-5-col-grid");
    		} else if($youmaxPro.width()<settings.responsiveBreakpoints[2]) {
    			$youmaxPro.addClass("yl-3-col-grid").removeClass("yl-1-col-grid yl-2-col-grid yl-4-col-grid yl-5-col-grid");
    		} else if($youmaxPro.width()<settings.responsiveBreakpoints[3]) {
    			$youmaxPro.addClass("yl-4-col-grid").removeClass("yl-1-col-grid yl-2-col-grid yl-3-col-grid yl-5-col-grid");
    		} else {
    			$youmaxPro.addClass("yl-5-col-grid").removeClass("yl-1-col-grid yl-2-col-grid yl-3-col-grid yl-4-col-grid");
    		}
    	}


		//set thumbnail type - simple|neat|full
    	if(settings.gridThumbnailType=="simple") {
    		$youmaxPro.addClass("yl-simple-thumbnails")
    	} else if(settings.gridThumbnailType=="neat") {
    		$youmaxPro.addClass("yl-neat-thumbnails")
    	} else {
    		$youmaxPro.addClass("yl-full-thumbnails")
    	}	


    	//set callout View - grid|list|double-list
    	if(settings.calloutType=="list") {
    		$youmaxPro.addClass("yl-list-callouts");
    	} else if(settings.calloutType=="grid") {
    		$youmaxPro.addClass("yl-grid-callouts");
    	} else if(settings.calloutType=="double-list") {
    		$youmaxPro.addClass("yl-double-list-callouts");
    	} 

    	//set simple popup view
    	if(settings.videoDisplayMode=="inline" && $youmaxPro.width()<900) {
    		$("body").addClass("yl-simple-popup");
    	} else if(settings.videoDisplayMode=="popup" && $("body").width()<900) {
    		$("body").addClass("yl-simple-popup");
    	}

	},

	handleResize = function($youmaxPro){

		$(window).resize(function() {
			handleYoumaxDisplay($youmaxPro);
		});

	},

	handleCallouts = function($youmaxPro) {

		var settings = $youmaxPro.data("settings");
		var calloutList = settings.callouts;
		var $calloutContainer = $youmaxPro.find(".yl-callout-container");
		var calloutImageHTML, calloutTextHTML, calloutBuyButtonHTML, calloutPreviewButtonHTML;

		if(null==calloutList || calloutList.length==0) {
			$youmaxPro.find(".yl-callout-container").hide();
            return;
		}

		for(var i=0; i<calloutList.length; i++) {
			
			calloutImageHTML = "<a target='_blank' class='yl-callout-buy-link' href='"+calloutList[i].buyButtonLink+"'><img src='"+calloutList[i].image+"'></a>";

			calloutTextHTML = "<div class='yl-callout-title'>"+calloutList[i].title+"</div><div class='yl-callout-description'>"+calloutList[i].description+"</div>";

			calloutBuyButtonHTML = "<a target='_blank' class='yl-callout-buy-link' href='"+calloutList[i].buyButtonLink+"'><div class='yl-callout-buy-button'>"+calloutList[i].buyButtonText+"</div></a>";

			calloutPreviewButtonHTML = "<a target='_blank' class='yl-callout-preview-link' href='"+calloutList[i].previewButtonLink+"'><div class='yl-callout-preview-button' title='preview'><i class='fa "+calloutList[i].previewButtonIcon+"'></i></div></a>";

			$calloutContainer.append("<div class='yl-callout'><div class='yl-callout-left'>"+calloutImageHTML+"</div><div class='yl-callout-right'>"+calloutTextHTML+calloutPreviewButtonHTML+calloutBuyButtonHTML+"</div></div>");
		}
		

	},

	handleOffers = function($youmaxPro) {

		var settings = $youmaxPro.data("settings");

		if(null!=settings.offerLink) {
			//offer present
			$youmaxPro.addClass("yl-offer-enabled");
			$youmaxPro.find(".yl-header").append("<a target='_blank' href='"+settings.offerLink+"'><div class='yl-offer'><div class='yl-offer-title'>"+settings.offerTitle+"</div><div class='yl-offer-description'>"+settings.offerDescription+"</div><div class='yl-offer-button'>"+settings.offerButtonText+"</div></div></a>");
		}

	},

	showLoader = function($youmaxPro) {

		$youmaxPro.find(".yl-inline-container").empty();
		$youmaxPro.find(".yl-item-container").empty().append("<div class='yl-loader'>Getting<br><span>Videos..</span></div>");

        $youmaxPro.find(".yl-showing-playlist-name").empty().hide();
	},


    saveSeenVideos = function($youmaxPro) {
        
        var seenVideos = [];

        $youmaxPro.find(".yl-seen").each(function(){
            seenVideos.push($(this).attr("id"));
        });

        return seenVideos;
    },

    highlightSeenVideos = function(seenVideos,$youmaxPro) {
        
        for(var k=seenVideos.length;k>=0;k--) {
            $youmaxPro.find("#"+seenVideos[k]).addClass("yl-seen");
        }
        
    },

    convertViews = function(views) {
    			
		var commaSeparatedViews = "";
		views = ""+views;
		
		while(views.length>0) {
			if(views.length > 3) {
				commaSeparatedViews = ","+views.substring(views.length-3)+commaSeparatedViews;
				views = views.substring(0,views.length-3);
			} else {
				commaSeparatedViews = views + commaSeparatedViews;
				break;
			}
		}
		
		return commaSeparatedViews;
    },

    convertDate = convertToSpecificDate,

	convertToSpecificDate = function(date) {
		//date incoming format "2016-08-26T21:48:14.000Z"
		var months = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
		var innerDate = date.substring(0,date.indexOf("T"));
		var splitDate = innerDate.split("-");
		//var returnDate = splitDate[2]+"-"+months[splitDate[1]-1]+"-"+splitDate[0];
		var returnDate = "<div class='yl-date'>"+splitDate[2]+"</div><div class='yl-month'>"+months[splitDate[1]-1]+"</div><div class='yl-year'>"+splitDate[0]+"</div>";

		//date outgoing format "26 Aug 2016"
		return returnDate;
	},

	//utility function to display time
	convertDuration = function(videoDuration) {
		
		var duration,returnDuration;
		videoDuration = videoDuration.replace('PT','').replace('S','').replace('M',':').replace('H',':');
		
		var videoDurationSplit = videoDuration.split(':');
		returnDuration = videoDurationSplit[0];
		for(var i=1; i<videoDurationSplit.length; i++) {
			duration = videoDurationSplit[i];
			if(duration=="") {
				returnDuration+=":00";
			} else {
				duration = parseInt(duration,10);
				if(duration<10) {
					returnDuration+=":0"+duration;
				} else {
					returnDuration+=":"+duration;
				}
			}
		}
		if(videoDurationSplit.length==1) {
			returnDuration="0:"+returnDuration;
		}
		return returnDuration;
		
	},

	//utility function to display time
	convertVimeoDuration = function(videoDuration) {

		var hours,min,sec;
		min = parseInt(videoDuration/60,10);
		sec = videoDuration - (min*60);
		
		if(sec<10) {
			sec="0"+sec;
		}
		
		if(min>=60) {
			hours = parseInt(min/60,10);
			min = min - (hours*60);
			
			if(min<10) {
				min="0"+min;
			}
			
			return hours+":"+min+":"+sec;
		} else {
			return min+":"+sec;
		}
	
	},


	convertToRelativeDate = function (timestamp) {
	
		var dateDiffMS, dateDiffHR, dateDiffDY, dateDiffMH, dateDiffYR;
		if(null==timestamp||timestamp==""||timestamp=="undefined")
			return "?";
		
		dateDiffMS = Math.abs(new Date() - new Date(timestamp));
		
		dateDiffHR = dateDiffMS/1000/60/60;
		if(dateDiffHR>24) {
			dateDiffDY = dateDiffHR/24;
			if(dateDiffDY>30) {
				dateDiffMH = dateDiffDY/30;
				if(dateDiffMH>12) {
					dateDiffYR = dateDiffMH/12;
					dateDiffYR = Math.round(dateDiffYR);
					if(dateDiffYR<=1) {
						return dateDiffYR+" <span>year ago</span>";
					} else {
						return dateDiffYR+" <span>years ago</span>";
					}						
				} else {
					dateDiffMH = Math.round(dateDiffMH);
					if(dateDiffMH<=1) {
						return dateDiffMH+" <span>month ago</span>";
					} else {
						return dateDiffMH+" <span>months ago</span>";
					}						
				}
			} else {
				dateDiffDY = Math.round(dateDiffDY);
				if(dateDiffDY<=1) {
					return dateDiffDY+" <span>day ago</span>";
				} else {
					return dateDiffDY+" <span>days ago</span>";
				}
			}
		} else {
			dateDiffHR = Math.round(dateDiffHR);
			if(dateDiffHR<1) {
				return "just now";
			}else if(dateDiffHR==1) {
				return dateDiffHR+" <span>hour ago</span>";
			} else {
				return dateDiffHR+" <span>hours ago</span>";
			}
		}		

	
	},

	processDescription = function(description) {
	
		var spotArray,replaceLink;

		description = description.replace(/"/g, "'");
		
		spotArray = description.match(/(http(s)*:\/\/|www\.).+?(\s|\n|$)/g);

		if(null!=spotArray) {
			for(var i=0;i<spotArray.length;i++) {
				spotArray[i] = spotArray[i].trim();
				description = description.replace(spotArray[i],"~~"+i+"~~");
			}

			for(var i=0;i<spotArray.length;i++) {

				if(spotArray[i].indexOf("www.")==0) {
					replaceLink = "http://"+spotArray[i];
				} else {
					replaceLink = spotArray[i];
				}
				description = description.replace("~~"+i+"~~","<a target='_blank' href='"+replaceLink+"' class='famax-link'>"+spotArray[i]+"</a>");
			}
		}
		
		return description;					
	},



	youmaxLoginToYouTube = function($youmaxPro) {

		var settings = $youmaxPro.data("settings");

		youmaxLoggedInUser.apiKey = settings.apiKey;

		gapi.auth.signIn({
			'clientid' 		: settings.youTubeClientId,
			'cookiepolicy' 	: 'single_host_origin',
			'callback' 		: 'youmaxSaveToken',
			'scope' 		: 'https://www.googleapis.com/auth/youtube.force-ssl'
		}); 

	},	


	handleYouTubeComments = function($youmaxPro) {

		if(youmaxLoggedInUser.token==null) {
			youmaxLoggedInUser.action="comment";
			youmaxLoginToYouTube($youmaxPro);
		} else {
			youmaxPostYouTubeComment($youmaxPro);
		}

	},

	handleYouTubeLikes = function($youmaxPro) {

		if(youmaxLoggedInUser.token==null) {
			youmaxLoggedInUser.action="like";
			youmaxLoginToYouTube($youmaxPro);
		} else {
			youmaxPostYouTubeLike($youmaxPro);
		}

	};


	$.fn.youmaxPro=function(options) {

		var $youmaxPro=this;
		var settings = $.extend({},localSettings,options);

		$youmaxPro.data("settings",settings);

		init($youmaxPro);
		doOptions($youmaxPro);
		initHeader($youmaxPro);
		handleTabs($youmaxPro);
		createTabs($youmaxPro);
		handleSearch($youmaxPro);
		handleSortOrders($youmaxPro);
		handleGridListSwitch($youmaxPro);
		handlePopupButtons($youmaxPro);
		handleAnimations($youmaxPro);
		handleLoadingMechanism($youmaxPro);
		handleResize($youmaxPro);
		handleCallouts($youmaxPro);
		handleOffers($youmaxPro);
		
		return this;

	}


})(jQuery);


function youmaxSaveToken(authResult) {
	
	if (authResult['status']['signed_in']) {
		youmaxLoggedInUser.token = authResult.access_token;

		if(youmaxLoggedInUser.action=="comment") {
			youmaxPostYouTubeComment();
			youmaxLoggedInUser.action=null;
		} else if(youmaxLoggedInUser.action=="like") {
			youmaxPostYouTubeLike();
			youmaxLoggedInUser.action=null;
		}
		
	}

}

function youmaxPostYouTubeComment() {

	var videoId = jQuery(".yp-post-likes").data("videoid");
	var comment = jQuery("#yp-add-comment-text").val();

	
	var postCommentURL = "https://www.googleapis.com/youtube/v3/commentThreads?part=snippet&shareOnGooglePlus=false&fields=snippet&key="+youmaxLoggedInUser.apiKey;
	var xmlComment = '{"snippet":{"videoId":"'+videoId+'","topLevelComment":{"snippet":{"textOriginal":"'+comment+'"}}}}';
		
	jQuery.ajax({
		url: postCommentURL,
		type: 'post',
		crossDomain: true,
		data:xmlComment,
		beforeSend: function(xhr){
			xhr.setRequestHeader('Authorization','Bearer '+youmaxLoggedInUser.token);
			xhr.setRequestHeader('Content-Type','application/json');
			xhr.setRequestHeader('Content-Length',xmlComment.length);
		},
		success: function (data, status) {

			var authorName = data.snippet.topLevelComment.snippet.authorDisplayName;
			var authorImage = data.snippet.topLevelComment.snippet.authorProfileImageUrl;	
			
			jQuery(".yp-post-comments").prepend("<div class='yp-comment'><div class='yp-comment-img'><img class='yp-comment-from-img' src='"+authorImage+"' /></div><div class='yp-comment-text'><span>"+authorName+"</span><br> "+comment+"</div></div>");

			jQuery(".yp-post-comment-users").prepend("<img src='"+authorImage+"' />");

			jQuery("#yp-add-comment-text").val("");

		},
		error: function (xhr, desc, err) {
			alert("Could not add comment");
			console.log(err);
		}
	});

}


function youmaxPostYouTubeLike() {

	if(youmaxLoggedInUser.likeListId==null) {
		getLikeListId();
	} else {
		addYouTubeLike();
	}
}

function getLikeListId() {


	var apiURL = "https://www.googleapis.com/youtube/v3/channels?mine=true&part=contentDetails%2Csnippet&key="+youmaxLoggedInUser.apiKey+"&access_token="+youmaxLoggedInUser.token;
	

	jQuery.ajax({
		url: apiURL,
		type: "GET",
		async: true,
		cache: true,
		dataType: 'json',
		success: function(response) {
			
			youmaxLoggedInUser.likeListId = response.items[0].contentDetails.relatedPlaylists.likes;
			youmaxLoggedInUser.picture = response.items[0].snippet.thumbnails.default.url;
			youmaxLoggedInUser.name = response.items[0].snippet.customUrl;
			addYouTubeLike();
			
		},
		error: function(html) { 
			
			alert("Could not add Like");
			
		}
	});
}

function addYouTubeLike() {

	var videoId = jQuery(".yp-post-likes").data("videoid");
	
	var postLikeURL = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&fields=snippet&key="+youmaxLoggedInUser.apiKey;
	var xmlLike = '{"snippet": {"resourceId": {"videoId": "'+videoId+'","kind": "youtube#video"},"playlistId": "'+youmaxLoggedInUser.likeListId+'"}}';

		
	jQuery.ajax({
		url: postLikeURL,
		type: 'post',
		crossDomain: true,
		data:xmlLike,
		beforeSend: function(xhr){
			xhr.setRequestHeader('Authorization','Bearer '+youmaxLoggedInUser.token);
			xhr.setRequestHeader('Content-Type','application/json');
			xhr.setRequestHeader('Content-Length',xmlLike.length);
		},
		success: function (data, status) {

			var authorImage = youmaxLoggedInUser.picture;			
			jQuery(".yp-post-like-count").after("<img src='"+authorImage+"'>");
            jQuery(".yp-post-likes").css("pointer-events","none");

		},
		error: function (xhr, desc, err) {
			alert("Could not add like");
			console.log(err);
		}

	});

}
