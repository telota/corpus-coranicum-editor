// Create confirmations
$('.delete-record').click(function(e) {
  e.preventDefault();

  if (confirm('Really delete record?')) {
    var url = $(this).prop('href');
    window.location.href = url;
  }
});
