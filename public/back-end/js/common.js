$(document).ready(function() {
    var table = $('#list-users, #list-patients, #list-categories').DataTable();

    $(document).on('click', '#user-list tbody>tr>td:last-child .btn-delete', function() {
        var id = $(this).data('id');
        var url = '/admin/user/' + id;
        $('#delete-user').find('form').attr('action', url);
        $('#delete-user').find('form input[name="id"]').val(id);
        $('#delete-user').modal('show');
    });
    $(document).on('click', '#patient-list tbody>tr>td:last-child .btn-delete', function() {
        var id = $(this).data('id');
        var url = '/admin/patient/' + id;
        $('#delete-patient').find('form').attr('action', url);
        $('#delete-patient').find('form input[name="id"]').val(id);
        $('#delete-patient').modal('show');
    });
    $(document).on('click', '#category-list tbody>tr>td:last-child .btn-delete', function() {
        var id = $(this).data('id');
        var url = '/admin/category/' + id;
        $('#delete-category').find('form').attr('action', url);
        $('#delete-category').find('form input[name="id"]').val(id);
        $('#delete-category').modal('show');
    });
    $(document).on('click', '#disease-list tbody>tr>td:last-child .btn-delete', function() {
        var id = $(this).data('id');
        var url = '/admin/disease/' + id;
        $('#delete-disease').find('form').attr('action', url);
        $('#delete-disease').find('form input[name="id"]').val(id);
        $('#delete-disease').modal('show');
    });
    $(document).on('click', '#vaccine-list tbody>tr>td:last-child .btn-delete', function() {
        var id = $(this).data('id');
        var url = '/admin/vaccine/' + id;
        $('#delete-vaccine').find('form').attr('action', url);
        $('#delete-vaccine').find('form input[name="id"]').val(id);
        $('#delete-vaccine').modal('show');
    });

    $(document).on('click', '#schedule-list tbody>tr>td:last-child .btn-delete', function() {
        var id = $(this).data('id');
        var url = '/admin/schedule/' + id;
        $('#delete-schedule').find('form').attr('action', url);
        $('#delete-schedule').find('form input[name="id"]').val(id);
        $('#delete-schedule').modal('show');
    });

    $(document).on('click', '#news-list tbody>tr>td:last-child .btn-delete', function() {
        var id = $(this).data('id');
        var url = '/admin/news/' + id;
        $('#delete-news').find('form').attr('action', url);
        $('#delete-news').find('form input[name="id"]').val(id);
        $('#delete-news').modal('show');
    });
    //Show profile of user
    $(document).on('click',
        '#user-list tbody>tr>td:last-child .btn-show-profile, #staff-list .btn-show-profile',
        function() {
        var id = $(this).data('id');
        var url = '/admin/user/' + id;
        $.ajax({
            method: "get",
            url: url
        })
            .done(function( data ) {
                console.log(data);
                if(data.is_admin) {
                    data.is_admin = 'Admin';
                } else {
                    data.is_admin = 'Normal User';
                }
                switch (data.gender) {
                    case 0:
                        data.gender = "Male";
                        break;
                    case 1:
                        data.gender = "Female";
                        break;
                    case 2:
                        data.gender = "Other";
                        break;
                }
                $('#user-profile').find('.profile-avatar').attr('src',data.avatar);
                $('#user-profile').find('.user-name').text(data.name);
                $('#user-profile').find('.user-email').text(data.email);
                $('#user-profile').find('.user-role').text(data.is_admin);
                $('#user-profile').find('.user-gender').text(data.gender);
                $('#user-profile').find('.user-address').text(data.address);
                $('#user-profile').find('.user-phone').text(data.phone);
                $('#user-profile').find('.user-idcard').text(data.identity_card);
                $('#user-profile').find('.user-major').text(data.major);
                $('#user-profile').find('.user-position').text(data.position);
                $('#user-profile').find('.user-birthday').text(data.birthday);
                $('#user-profile').modal('show');
            });
    });
    //Show profile of patient
    $(document).on('click', '#patient-list tbody>tr>td:last-child .btn-show-profile', function() {
        var id = $(this).data('id');
        var url = window.location.pathname + '/' + id;
        $.ajax({
            method: "get",
            url: url
        })
            .done(function( data ) {
                switch (data.gender) {
                    case 0:
                        data.gender = "Male";
                        break;
                    case 1:
                        data.gender = "Female";
                        break;
                    case 2:
                        data.gender = "Other";
                        break;
                }
                $('#patient-profile').find('.profile-avatar').attr('src',data.avatar);
                $('#patient-profile').find('.patient-name').text(data.fullname);
                $('#patient-profile').find('.patient-email').text(data.email);
                $('#patient-profile').find('.patient-gender').text(data.gender);
                $('#patient-profile').find('.patient-address').text(data.address);
                $('#patient-profile').find('.patient-phone').text(data.phone);
                $('#patient-profile').find('.patient-idcard').text(data.identity_card);
                $('#patient-profile').find('.patient-birthday').text(data.birthday);
                $('#patient-profile').modal('show');
            });
    });

    //Show detail of category
    $(document).on('click', '#category-list tbody>tr>td:last-child .btn-show-profile', function() {
        var id = $(this).data('id');
        var url = '/admin/category/' + id;
        $.ajax({
            method: "get",
            url: url
        })
            .done(function( data ) {
                $('#category-information').find('.category-name').text(data.name);
                $('#category-information').find('.category-description').html(data.description.replace(/\n/g, "<br>"));
                $('#category-information').modal('show');
            });
    });

    //Show detail of diseases
    $(document).on('click', '#disease-list tbody>tr>td:last-child .btn-show-profile', function() {
        var id = $(this).data('id');
        var url = '/admin/disease/' + id;
        $.ajax({
            method: "get",
            url: url
        })
            .done(function( data ) {
                $('#disease-information').find('.disease-name').text(data.name);
                $('#disease-information').find('.disease-symptom').html(data.symptom.replace(/\n/g, "<br>"));
                $('#disease-information').modal('show');
            });
    });

    //Show detail of vaccine
    $(document).on('click',
        '#vaccine-list tbody>tr>td:last-child .btn-show-profile, #vaccine-list-2 .btn-show-profile',
        function() {
        var id = $(this).data('id');
        var url = '/admin/vaccine/' + id;
        $.ajax({
            method: "get",
            url: url
        })
            .done(function( data ) {
                $('#vaccine-information').find('.vaccine-name').text(data.name);
                $('#vaccine-information').find('.vaccine-description').html(data.description.replace(/\n/g, "<br>"));
                $('#vaccine-information').find('.vaccine-category').text(data.category.name);
                $('#vaccine-information').find('.vaccine-disease').text(data.disease.name);
                $('#vaccine-information').find('.vaccine-price').text(data.price + " VND");
                $('#vaccine-information').find('.profile-avatar').attr('src',data.image);
                $('#vaccine-information').modal('show');
            });
    });

    //Show detail of vaccine
    $(document).on('click', '#schedule-list tbody>tr>td:last-child .btn-show-profile', function() {
        var id = $(this).data('id');
        var url = window.location.pathname + '/' + id;
        $.ajax({
            method: "get",
            url: url
        })
            .done(function( data ) {
                $('#schedule-information').find('.schedule-title').text(data.title);
                $('#schedule-information').find('.schedule-content').html(data.content.replace(/\n/g, "<br>"));
                $('#schedule-information').find('.schedule-start-date').text(data.start_date);
                $('#schedule-information').find('.schedule-end-date').text(data.end_date);
                var state = data.state == 0 ? 'Coming' : 'Closed';
                $('#schedule-information').find('.schedule-state').text(state);
                var users = data.users;
                var content = "";
                var i = 1;
                for (x in users) {
                    content += "<tr><td class='col-sm-1 col-xs-1'>"+ i++ +"</td>";
                    content += "<td class='col-sm-3 col-xs-3'>" + users[x].name +"</td>";
                    content += "<td class='col-sm-3 col-xs-3'>" + users[x].phone +"</td>";
                    content += "<td class='col-sm-3 col-xs-3'>" + users[x].major +"</td>";
                    content += "<td class='col-sm-2 col-xs-2'>" + users[x].position +"</td>";
                    content += "</tr>";
                }
                var vaccines = data.vaccines;
                var content1 = "";
                i = 1;
                for (x in vaccines) {
                    content1 += "<tr><td>"+ i++ +"</td>";
                    content1 += "<td>" + vaccines[x].name +"</td>";
                    content1 += "<td>" + vaccines[x].price +"</td>";
                    content1 += "</tr>";
                }
                $('#schedule-information').find('.list-staff tbody').html(content);
                $('#schedule-information').find('.list-vaccine tbody').html(content1);
                $('#schedule-information').modal('show');
            });
    });

    $("input[name='avatar'], input[name='image']").change(function(e){
        readURL(this);
        // $(this).siblings('img').attr("src",url);

    });
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('.profile-avatar').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $('#sidebar-menu li').click(function (e) {
        $(this).find('ul').toggle();
        if ($(this).find('ul').is(":visible")) {
            $(this).addClass('open');
        } else {
            $(this).removeClass('open');

        }
    });

    $.validator.addMethod("customemail",
        function (value, element) {
            var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(value);
        },
        "Please enter a valid email address. For example johndoe@domain.com."
    );

    $(".form-validate-user-update").validate({
        rules: {
            name: {
                required: true,
            },
            email: {
                required: true,
                customemail: true
            },
            password: {
                minlength: 6,
            },
            address: {
                required: true,
            },
            phone: {
                required: true,
                number: true,
                rangelength: [10, 11]
            },
            birthday: {
                required: true
            },
            identity_card: {
                required: true,
                number: true,
                rangelength: [9, 20]
            },
            position: {
                required: true
            },
            major: {
                required: true
            },
            is_admin: {
                required: true,
                number: true,
                rangelength: [0, 1]
            },
            gender: {
                required: true,
                number: true,
                rangelength: [0, 2]
            }
        },
        submitHandler: function (form) {
            form.submit();
        }
    });

    $(".form-validate-user-add").validate({
        rules: {
            name: {
                required: true,
            },
            email: {
                required: true,
                customemail: true
            },
            password: {
                required: true,
                minlength: 6,
            },
            address: {
                required: true,
            },
            phone: {
                required: true,
                number: true,
                rangelength: [10, 11]
            },
            birthday: {
                required: true
            },
            identity_card: {
                required: true,
                number: true,
                rangelength: [9, 20]
            },
            position: {
                required: true
            },
            major: {
                required: true
            },
            is_admin: {
                required: true,
                number: true,
                rangelength: [0, 1]
            },
            gender: {
                required: true,
                number: true,
                rangelength: [0, 2]
            }
        },
        submitHandler: function (form) {
            form.submit();
        }
    });

    $(".form-validate-patient").validate({
        rules: {
            fullname: {
                required: true,
            },
            email: {
                required: true,
                customemail: true
            },
            address: {
                required: true,
            },
            phone: {
                required: true,
                number: true,
                rangelength: [10, 11]
            },
            birthday: {
                required: true
            },
            identity_card: {
                required: true,
                number: true,
                rangelength: [9, 20]
            },
            position: {
                required: true
            },
            major: {
                required: true
            },
            gender: {
                required: true,
                number: true,
                rangelength: [0, 2]
            }
        },
        submitHandler: function (form) {
            form.submit();
        }
    });

    $(".form-validate-profile").validate({
        rules: {
            name: {
                required: true,
            },
            email: {
                required: true,
                customemail: true
            },
            address: {
                required: true,
            },
            phone: {
                required: true,
                number: true,
                rangelength: [10, 11]
            },
            birthday: {
                required: true
            },
            identity_card: {
                required: true,
                number: true,
                rangelength: [9, 20]
            },
            position: {
                required: true
            },
            major: {
                required: true
            },
            gender: {
                required: true,
                number: true,
                rangelength: [0, 2]
            }
        },
        submitHandler: function (form) {
            form.submit();
        }
    });
} );