$(document).ready(function(){
  // hilangkan tombol cari
  $('#tombolCari').hide();

  // event ketika keyword ditulis
  $('#keyword').on('keyup', function(){
    // munculkan icon loading
    $('.loading').show();
    // $('#container').load('ajax/mahasiswa.php?keyword='+$('#keyword').val());

    // $.get()
    $.get('ajax/mahasiswa.php?keyword='+ $('#keyword').val(), function(data){
      $('#container').html(data);
      $('.loading').hide();
    });
  });
});
