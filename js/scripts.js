$(document).ready(function() {
    $('#to_do_table').DataTable({
        "pageLength": 3,
        "bLengthChange": false,
        "searching": false,
        "order": []
    });

    $('#to_do_table tbody').on('dblclick', 'tr', function() {
        self.Editor.edit(this);
    });

    $('#signinModal').modal('show');

    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
    $('#edit_status').change(function() {
        if ($(this).val() == "on" || $(this).val() == 1)
            $(this).val(0)
        else
            $(this).val(1)

    });

    $("#edit_form").on('submit', function() {
        if ($("#edit_status").prop('checked'))
            $("#edit_status").val(1)
        else
            $("#edit_status").val(0)
    })
});

function sendEditInfo(id) {
    axios.get(`api/todo/get.php?id=${id}`)
        .then(function(response) {
            $('#edit_title').val(response.data.result[0].title)
            $('#edit_description').val(response.data.result[0].description)
            $('#edit_email').val(response.data.result[0].user_email)
            $('#edit_name').val(response.data.result[0].user_name)
            $('#edit_id').val(response.data.result[0].id)

            if (response.data.result[0].done == 1)
                $('#edit_status').prop('checked', true).val(1)
            else
                $('#edit_status').prop('checked', false).val(0)

        })
        .catch(function(error) {
            console.log(error);
        })

}