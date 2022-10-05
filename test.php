$(."check-box").click(function(e) {
                const id = $(this).attr('data-todo-id');

                $.post("app/check.php",
                {
                    id: id
                },
                (data) => {
                    if (data != "error")  {
                        const h2 = $(this).next();
                        if(data === '1') {
                            h2.removeClass('checked');
                        } else {
                            h2.addClass('checked');
                        }
                    }
                }
            });
        });