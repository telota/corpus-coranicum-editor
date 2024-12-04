// Initialize all tables to be datables and set default sorting
$('.dataTable').DataTable({
  lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'All']],
  iDisplayLength: -1,
  bsortClasses: false,
});

// Set alternate sorting for leser tables
$('#leser-table')
  .dataTable()
  .fnSort([2, 'asc']);

// Set alternate sorting for leser tables
$('#lesearten-table')
  .dataTable()
  .fnSort([[2, 'asc'], [1, 'asc']]);

// Set alternate sorting for umwelttexte table
$('#umwelttexte-table')
  .dataTable()
  .fnSort([0, 'desc']);
