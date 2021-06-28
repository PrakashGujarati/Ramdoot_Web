<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
        <title>RamdootEduWorld</title>
        <link rel="preconnect" href="https://fonts.gstatic.com" />
        <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;500;700;900&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="{{ asset('video_demo/styles/bootstrap.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('video_demo/fonts/css/fontawesome-all.min.css')}}" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>                
    </head>
    <body class="theme-light">
        <div id="preloader"><div class="spinner-border color-highlight" role="status"></div></div>
        <div id="page">
            <div class="header header-fixed header-dark header-logo-app">
                <a href="#" class="header-title">RamdootEduWorld</a>   
                <input style="float:right;margin-top:15px;margin-right:15px;width:30%" name="url"  id="url" readonly>
            </div>            
           <script>
			  // 2. This code loads the IFrame Player API code asynchronously.
			  var tag = document.createElement('script');

			  tag.src = "https://www.youtube.com/iframe_api";
			  var firstScriptTag = document.getElementsByTagName('script')[0];
			  firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

			  // 3. This function creates an <iframe> (and YouTube player)
			  //    after the API code downloads.
			  var player;
			  function onYouTubeIframeAPIReady() {
				player = new YT.Player('player', {
				  height: '480',
				  width: '854',
				  videoId: 'sv5hK4crIRc',		  
				  playerVars: {
					'playsinline': 1
				  },
				  events: {
					'onReady': onPlayerReady,
					'onStateChange': onPlayerStateChange
				  }
				});
				
			  }

			  // 4. The API will call this function when the video player is ready.
			  function onPlayerReady(event) {
				player.seekTo(5,true);		
				event.target.playVideo();	
				
			  }


        function loadVideo()
        {
          var title = $("#video_id option:selected").html();
          var res = title.split("#");
          $("#title").val(res[0]);
          $("#subtitle").val(res[1]);
          var video_id = $("#video_id").val();
          alert(video_id);
          $("#url").val(video_id);
          player.loadVideoById(video_id);        
        }

			  // 5. The API calls this function when the player's state changes.
			  //    The function indicates that when playing a video (state=1),
			  //    the player should play for six seconds and then stop.
			  var done = false;
			  function onPlayerStateChange(event) {	  
					//console.log(player.getDuration());
					//console.log(player.playerInfo.currentTime);
				  //console.log(player.getCurrentTime());
				 //console.log(event.target.playerInfo.currentTime);//currenttime
				 //console.log(event.target.playerInfo.duration);//duration
         $("#duration").val(secondsToHms(parseInt(player.getDuration())));
          $("#starttime").val(secondsToHms(parseInt(player.getCurrentTime())));
          if (event.data == YT.PlayerState.PLAYING && !done) {
            setTimeout(stopVideo, 6000);
            done = true;
          }
			  }
			 
        function stopVideo() {
				  player.stopVideo();
			  }
			  function pauseVideo() {
				  player.pauseVideo();
			  }
			  function playVideo() {
				  player.playVideo();
			  }

        function getStart() {
				  console.log(player.getCurrentTime());
          //alert(player.getCurrentTime());
          //console.log(player.getDuration());
          $("#duration").val(secondsToHms(parseInt(player.getDuration())));
          $("#starttime").val(secondsToHms(parseInt(player.getCurrentTime())));
			  }

        function secondsToHms(d) {
            d = Number(d);
            var h = Math.floor(d / 3600);
            var m = Math.floor(d % 3600 / 60);
            var s = Math.floor(d % 3600 % 60);

            var hDisplay = h > 0 ? h + (h == 1 ? " hour, " : " hours, ") : "";
            var mDisplay = m > 0 ? m + (m == 1 ? " minute, " : " minutes, ") : "";
            var sDisplay = s > 0 ? s + (s == 1 ? " second" : " seconds") : "";
            //return hDisplay + mDisplay + sDisplay; 
            if(h>0)
            {
              return h+":"+m+":"+s;
            }else if(m>0)
            {
              return m+":"+s;
            }else{
              return s;
            }
        }
			  
			</script>
            <div class="page-content header-clear">
                <div class="responsive-iframe mb-4">
                   <div id="player"></div>
                </div>
                <div class="content">
                    <div id="validator-name" class="disabled bg-red-dark content rounded-sm shadow-xl text-center line-height-xs py-3 text-uppercase font-700">Name is required!</div>
                    <div id="validator-mail1" class="disabled bg-red-dark content rounded-sm shadow-xl text-center line-height-xs py-3 text-uppercase font-700">Email Address is required!</div>
                    <div id="validator-mail2" class="disabled bg-red-dark content rounded-sm shadow-xl text-center line-height-xs py-3 text-uppercase font-700">Invalid email Address!</div>
                    <div id="validator-text" class="disabled bg-red-dark content rounded-sm shadow-xl text-center line-height-xs py-3 text-uppercase font-700">Please enter your message!</div>
                    <div class="form-sent disabled">
                        <h1 class="color-white text-center pt-4"><i class="fa fa-check-circle fa-3x shadow-s scale-box color-green-dark rounded-circle"></i></h1>
                        <h4 class="text-center pb-4">Message Sent</h4>
                        <div class="text-center mt-n3">
                            <p class="boxed-text-xl">
                                Here are our social media platforms! Follow us for the latest updates or just say hello!
                            </p>
                            <a href="#" class="icon icon-m shadow-xl bg-facebook"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="icon icon-m shadow-xl bg-instagram ms-3 me-3"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="icon icon-m shadow-xl bg-twitter"><i class="fab fa-twitter"></i></a>
                        </div>
                    </div>
                    <form action="php/contact.php" method="post" class="contactForm" id="contactForm">
                        <fieldset>
                            <div class="form-field form-name">                                
                                <button type="button" id="getstarttime" onclick="getStart()"><img src="{{ asset('video_demo/images/48x48.png')}}" height="30px;" class="fa fa-clock-o" style="padding-right:5px;" aria-hidden="true"></button>
                                <input style="width:12%" name="starttime"  id="starttime" placeholder="Start Time">
                                <input style="width:12%" name="duration"  id="duration" placeholder="Duration">
                                <input style="width:30%" name="title"  id="title" placeholder="Title">
                                <input style="width:30%" name="subtitle"  id="subtitle" placeholder="Subtitle">
                            </div>
                            <div style="width:49%;float: left;">
                              <div class="form-field form-name">
                                <label class="contactNameField color-theme" for="contactNameField">Board - Medium:</label>
                                <select name="board_id" id="board_id" class="form-control" onchange="getStandardByBoard();">
                                  <option value="">Select Board</option>
                                  <option value="19">GSEB - ગુજરાતી માધ્યમ</option>
                                  <option value="22">GSEB - English Medium</option>                                  
                                  <option value="26">CBSE - हिन्दी</option>
                                  <option value="25">CBSE - English Medium</option>
                                  <option value="27">BSEB - Hindi Medium</option>
                                  <option value="28">BSEB - English Medium</option>
                                  </select>
                              </div>
                              <div class="form-field form-email">
                                  <label class="contactEmailField color-theme" for="contactEmailField">Standard:</label>
                                  <select name="standard_id" id="standard_id" class="form-control" onchange="getSubjectByStandard();">
                                    <option value="">Standard Id</option>
                                  </select>
                              </div>
                              <div class="form-field form-name">
                                <label class="contactNameField color-theme" for="contactNameField">Subject:</label>
                                <select class="form-control" name="subject_id" id="subject_id"  onchange="getChapterBySubject();">
                                  <option value="">Subject Id</option>
                                </select>
                              </div>
                              <div class="form-field form-email">
                                  <label class="contactEmailField color-theme" for="contactEmailField">Chapter:</label>
                                  <select class="form-control" name="chapter_id" id="chapter_id" onchange="getVideosByChapter();">
                                    <option value="">Chapter Id</option>
                                  </select>
                              </div>                              
                              <div class="form-field form-email">
                                <label class="contactEmailField color-theme" for="contactEmailField">Video:</label>
                                <select class="form-control" name="video_id" id="video_id" onchange="loadVideo();">
                                  <option value="">Video Id</option>
                                </select>
                              </div>
                            </div>
                            <div style="width:49%;float: right;">
                              <div class="form-field form-name">
                                <label class="contactNameField color-theme" for="contactNameField">Board:</label>
                                <select name="set_board_id" id="set_board_id" class="form-control" onchange="setMediumByBoard();">
                                  <option value="">--Select Board--</option>
                                  @foreach($boards as $boards_data)
                                  <option value="{{ $boards_data->id }}" @if(old('board_id') == $boards_data->id) selected="" @endif>{{ $boards_data->name}}</option>
                                  @endforeach                                  
                                  </select>
                              </div>
                              <div class="form-field form-name">
                                <label class="contactNameField color-theme" for="contactNameField">Medium:</label>
                                <select name="set_medium_id" class="form-control" id="set_medium_id" onchange="setStandardByBoard();">
                                    <option value="">--Select Medium--</option>
                                </select>
                              </div>

                              <div class="form-field form-email">
                                  <label class="contactEmailField color-theme" for="contactEmailField">Standard:</label>
                                  <select name="set_standard_id" id="set_standard_id" class="form-control" onchange="setSubjectByStandard();">
                                    <option value="">Standard Id</option>
                                  </select>
                              </div>
                              <div class="form-field form-name">
                                <label class="contactNameField color-theme" for="contactNameField">Subject:</label>
                                <select class="form-control" name="set_subject_id" id="set_subject_id"  
                                onchange="setSemesterBySubject();">
                                  <option value="">Subject Id</option>
                                </select>
                              </div>
                              <div class="form-field form-name">
                                <label class="contactNameField color-theme" for="contactNameField">Semester / Sub Subject:</label>
                                <select class="form-control" name="set_semester_id" id="set_semester_id"  onchange="setChapterBySemester();">
                                  <option value="">Semester Id</option>
                                </select>
                              </div>
                              <div class="form-field form-name mb-2">
                                <label class="contactNameField color-theme" for="contactNameField">Chapter:</label>
                                <select class="form-control" name="set_chapter_id" id="set_chapter_id">
                                  <option value="">Chapter Id</option>
                                </select>
                              </div>
                            </div>
                            <br/>
                            <div class="form-button">                              
                                <label class="contactNameField color-theme" for="contactNameField">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                              <input type="button" class="btn bg-dark text-uppercase font-900 btn-m btn-full border-0 rounded-sm shadow-xl contactSubmitButton" onclick="postParams()" value="Submit" /> 
                            </div>
                        </fieldset>
                    </form>
                </div>                
                <div class="content mb-0">
					          <div class="pb-0 mb-0 divider"></div>                    
                    <p class="p-0 m-0" style="float:right">RamdootEdu.World</p>                                        
                </div>
            </div>
        </div>
        <script type="text/javascript" src="{{ asset('video_demo/scripts/bootstrap.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('video_demo/scripts/custom.js')}}"></script>
        <script type="text/javascript" src="{{ asset('video_demo/scripts/own.js')}}"></script>
        <script>
          
          $( document ).ready(function() {

              $.ajax({
                      url: "{{route('setBoardMediumData')}}",
                      type: "GET",
                      success: function(html) {
                          $("#set_board_id").html(html);                  
                      }
              });

              // $.post("ajax.php", {
              //     setBoardMediumData: 'setBoardMediumData'
              // }, function(data) {
              //     $("#set_board_id").html(data);
              // });
          });

          
          function setMediumByBoard() {
              var board_id = $("#set_board_id").val();
              $.ajax({
                  type: "GET",
                  url: "{{route('get.medium')}}",
                  data: {
                      "board_id":board_id,
                  },
                  success: function(result) {
                      $('#set_medium_id').html(result.html);
                  }
              });
          }

          function setStandardByBoard() {
              var board_id = $("#set_board_id").val();
              var medium_id = $('#set_medium_id').val();
              $.ajax({
                  type: "GET",
                  url: "{{route('get.standard')}}",
                  data: {
                      "board_id":board_id,
                      "medium_id":medium_id,
                  },
                  success: function(result) {
                      $('#set_standard_id').html(result.html);
                  }
              });
              // $.post("ajax.php", {
              //     setStandardData: 'setStandardData',
              //     board_id: board_id
              // }, function(data) {
              //     $("#set_standard_id").html(data);
              // });
          }

          function setSubjectByStandard(){
              var board_id = $("#set_board_id").val();
              var medium_id = $('#set_medium_id').val();
              var standard_id = $("#set_standard_id").val();
              
              $.ajax({
                  type: "GET",
                  url: "{{route('get.subject')}}",
                  data: {
                      "board_id":board_id,
                      "medium_id":medium_id,
                      "standard_id":standard_id,
                  },
                  success: function(result) {
                      $('#set_subject_id').html(result.html);
                  }
              });

              // $.post("ajax.php", {
              //     setSubjectData: 'setSubjectData',
              //     board_id: board_id,
              //     standard_id: standard_id,
              // }, function(data) {
              //     $("#set_subject_id").html(data);
              // });
          }

          function setSemesterBySubject(){
              var board_id = $("#set_board_id").val();
              var medium_id = $('#set_medium_id').val();
              var standard_id = $("#set_standard_id").val();
              var subject_id = $("#set_subject_id").val();
                
              $.ajax({
                  type: "GET",
                  url: "{{route('get.semester.unit')}}",
                  data: {
                      "board_id":board_id,
                      "medium_id":medium_id,
                      "standard_id":standard_id,
                      "subject_id":subject_id,
                  },
                  success: function(result) {
                    $('#set_semester_id').html('');
                      $('#set_semester_id').html(result.html);
                  }
              }); 

              // $.post("ajax.php", {
              //     setSemesterBySubject: 'setSemesterBySubject',
              //     board_id: board_id,
              //     standard_id: standard_id,
              //     subject_id: subject_id
              // }, function(data) {
              //     $("#set_semester_id").html(data);
              // });
          }

          function setChapterBySemester(){
              var board_id = $("#set_board_id").val();
              var medium_id = $('#set_medium_id').val();
              var standard_id = $("#set_standard_id").val();              
              var subject_id = $("#set_subject_id").val();
              var semester_id = $("#set_semester_id").val();
              
              $.ajax({
                  type: "GET",
                  url: "{{route('get.unit')}}",
                  data: {
                      "board_id":board_id,
                      "medium_id":medium_id,
                      "standard_id":standard_id,
                      "subject_id":subject_id,
                      "semester_id":semester_id,
                  },
                  success: function(result) {
                      $('#set_chapter_id').html(result.html);
                  }
              }); 


              // $.post("ajax.php", {
              //     setChapterBySubject: 'setChapterBySubject',
              //     board_id: board_id,
              //     standard_id: standard_id,
              //     subject_id: subject_id,
              //     semester_id: semester_id
              // }, function(data) {
              //     $("#set_chapter_id").html(data);
              // });
          }

          function postParams() {
              var board_id = $("#set_board_id").val();
              var board = $("#set_board_id option:selected").html();
              var bid = $("#set_board_id").find(':selected').attr('bid');
              var medium_id = $('#set_medium_id').val();
              var standard_id = $("#set_standard_id").val();
              var standard = $("#set_standard_id option:selected").html();
              var subject_id = $("#set_subject_id").val();
              var subject = $("#set_subject_id option:selected").html();
              var semester_id = $("#set_semester_id").val();
              var semester = $("#set_semester_id option:selected").html();
              var chapter_id = $("#set_chapter_id").val();
              var chapter = $("#set_chapter_id option:selected").html();
              var start_time = $("#starttime").val();
              var duration = $("#duration").val();
              var title = $("#title").val();
              var url_video = $("#url").val();
              var subtitle = $("#subtitle").val();

              $.ajax({
                  type: "GET",
                  url: "{{route('videodata_store')}}",
                  data: {
                          //postParams: 'postParams',
                          bid: bid,
                          board_id: board_id,
                          board: board,
                          standard_id: standard_id,
                          standard: standard,
                          medium_id:medium_id,
                          subject_id: subject_id,
                          subject: subject,
                          semester_id: semester_id,
                          semester: semester,
                          chapter_id: chapter_id,
                          chapter: chapter,
                          start_time : start_time,
                          duration: duration,
                          title: title,
                          subtitle: subtitle,
                          url_video: url_video,
                  },
                  success: function(result) {
                      console.log(data);
                  }
              }); 


              // $.post("ajax.php", {
              //     postParams: 'postParams',
              //     bid: bid,
              //     board_id: board_id,
              //     board: board,
              //     standard_id: standard_id,
              //     standard: standard,
              //     subject_id: subject_id,
              //     subject: subject,
              //     semester_id: semester_id,
              //     semester: semester,
              //     chapter_id: chapter_id,
              //     chapter: chapter,
              //     start_time : start_time,
              //     duration: duration,
              //     title: title,
              //     subtitle: subtitle,
              //     url: url,
              // }, function(data) {
              //     console.log(data);
              // });
          }

          function getStandardByBoard() {
              var board_id = $("#board_id").val();
              $.ajax({
                      url: "{{route('getStandardData')}}",
                      type: "GET",
                      data: {
                        //getSubjectByStandard: 'getSubjectByStandard',
                        board_id: board_id,
                      },
                      success: function(html) {
                          $("#standard_id").html(html);                  
                      }
              });

              // $.post("ajax.php", {
              //     getStandardByBoard: 'getStandardByBoard',
              //     board_id: board_id
              // }, function(data) {
              //     $("#standard_id").html(data);
              // });
          }
  
          function getSubjectByStandard() {
              var board_id = $("#board_id").val();
              var board = $("#board_id option:selected").html();
                    var standard_id = $("#standard_id").val();
              var standard = $("#standard_id option:selected").html();
              $.ajax({
                      url: "{{route('getSubjectData')}}",
                      type: "GET",
                      data: {
                        //getSubjectByStandard: 'getSubjectByStandard',
                        board_id: board_id,
                        board: board,
                        standard_id: standard_id,
                        standard: standard
                      },
                      success: function(html) {
                          $("#subject_id").html(html);                  
                      }
              });

              // $.post("ajax.php", {
              //     getSubjectByStandard: 'getSubjectByStandard',
              //     board_id: board_id,
              //     board: board,
              //     standard_id: standard_id,
              //     standard: standard
              // }, function(data) {
              //     $("#subject_id").html(data);
              // });
          }
  
          function getChapterBySubject() {
              var board_id = $("#board_id").val();
              var board = $("#board_id option:selected").html();
              var standard_id = $("#standard_id").val();
              var standard = $("#standard_id option:selected").html();
              var subject_id = $("#subject_id").val();
              var subject = $("#subject_id option:selected").html();

              $.ajax({
                      url: "{{route('getChapterData')}}",
                      type: "GET",
                      data: {
                        board_id: board_id,
                        board: board,
                        standard_id: standard_id,
                        standard: standard,
                        subject_id: subject_id,
                        subject: subject
                      },
                      success: function(html) {
                          $("#chapter_id").html(html);                  
                      }
              });


              // $.post("ajax.php", {
              //     getChapterBySubject: 'getChapterBySubject',
              //     board_id: board_id,
              //     board: board,
              //     standard_id: standard_id,
              //     standard: standard,
              //     subject_id: subject_id,
              //     subject: subject
              // }, function(data) {
              //     $("#chapter_id").html(data);
              // });
          }


          function getVideosByChapter() {
              var board_id = $("#board_id").val();
              var board = $("#board_id option:selected").html();
              var standard_id = $("#standard_id").val();
              var standard = $("#standard_id option:selected").html();
              var subject_id = $("#subject_id").val();
              var subject = $("#subject_id option:selected").html();
              var chapter_id = $("#chapter_id").val();
              var chapter = $("#chapter_id option:selected").html();
              
              $.ajax({
                      url: "{{route('video_getdata')}}",
                      type: "GET",
                      data: {
                        board_id: board_id,
                        board: board,
                        standard_id: standard_id,
                        standard: standard,
                        subject_id: subject_id,
                        subject: subject,
                        chapter_id: chapter_id,
                        chapter: chapter,
                      },
                      success: function(html) {
                          $("#video_id").html(html);                  
                      }
              });

              // $.post("ajax.php", {
              //     getVideosByChapter: 'getVideosByChapter',
              //     board_id: board_id,
              //     board: board,
              //     standard_id: standard_id,
              //     standard: standard,
              //     subject_id: subject_id,
              //     subject: subject,
              //     chapter_id: chapter_id,
              //     chapter: chapter,
              // }, function(data) {
              //     $("#video_id").html(data);
              // });
          }  

            
      </script>
    </body>
</html>
