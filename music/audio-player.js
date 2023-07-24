$(document).ready(function(){
    if(getCookie('src') != ''){
      var parsed = JSON.parse(getCookie('src'))
      var q = getCookie('pq') != '' ? getCookie('pq') : '';
      play_music(parsed,q,0)
    }
  })
  function _player(_this){
    var type = _this.attr('data-type')
    if($('#mplayer source').length <= 0)
      return false;
    if(type == 'play'){
      _this.attr('data-type','pause')
      _this.html('<i class="fa fa-pause"></i>')
      document.getElementById('mplayer').play()
    }else{
      _this.attr('data-type','play')
      _this.html('<i class="fa fa-play"></i>')
      document.getElementById('mplayer').pause()
    }
  }

  function play_music($src,$i=0,$p = 1){
    var audio = $('<audio controls class="bg-black" id="mplayer" data-queue = "'+$i+'"></audio>')
    if(typeof $src === 'object'){
      src_arr = $src;
      $src = $src[$i].upath;
    }

    document.cookie = "src="+JSON.stringify(src_arr);
    document.cookie = "pq="+$i;
    var csrc = $('#mplayer source').attr("src");
    if($src != csrc){
      audio.append('<source src="'+$src+'">');
      var player = $('#audio-player');
      player.find('audio').remove();
      player.append(audio);
      get_details(src_arr[$i].id);
    }else{
      if(!document.getElementById('mplayer').paused == true){
        document.getElementById('mplayer').pause();
        return false;
      }
    }
    
    if($p == 1){
      document.getElementById('mplayer').play();
      $('.p-player').attr('data-type','pause');
      $('.p-player').html('<i class="fa fa-pause"></i>');
    }
    m_end();
  }
  
  function _prev() {
var $i = parseInt($('#mplayer').attr('data-queue')) - 1;
if (!!src_arr[$i]) {
play_music(src_arr, $i, 1);
}
}
  
function _next() {
var $i = parseInt($('#mplayer').attr('data-queue')) + 1;
if (!!src_arr[$i] && !!src_arr[$i].upath) {
play_music(src_arr, $i, 1);
} else {
play_music(src_arr, 0, 1);
}
}
  
  function m_end(){
    document.getElementById('mplayer').addEventListener('ended',function(){
      $('.p-player').attr('data-type','play');
      $('.p-player').html('<i class="fa fa-play"></i>');
      document.getElementById('mplayer').duration = 0;
      _next(parseInt($('#mplayer').attr('data-queue'))+1);
    });
  }

  function get_details($id){
    $.ajax({
      url:"ajax.php?action=get_details",
      method:'POST',
      data:{id:$id},
      success:function(resp){
        if(resp){
          resp = JSON.parse(resp);
          var _html = '<div id="pdet" class="d-flex justify-content-center align-items-center" style="color:black;"><img src="assets/uploads/'+resp.cover_image+'" alt="" class="img-thumbnail bg-gradient-1" style="width: 60px;height: 60px;object-fit: cover;background:none;"><div class="ml-2 mr-4"><div><b><large>'+resp.title+'</large></b></div><div><b><small>'+resp.artist+'</small></b></div></div></div>';
          if($('#audio-player #pdet').length > 0)
            $('#audio-player #pdet').remove();
          $('#audio-player').prepend(_html);
        }
      }
    });
  }