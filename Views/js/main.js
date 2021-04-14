$(function() {
    // $('#getBookInfo').click( function() {
    //     e.preventDefault();
        const isbn = $("#isbn13").val();
        const url = "https://api.openbd.jp/v1/get?isbn=" + isbn;

        $.getJSON( url, function( data ) {
            if( data[0] == null ) {
                alert("データが見つかりません");
            } else {
                if( data[0].summary.cover == "" ){
                    $("#thumbnail").html('<img src=\"\" />');
                } else {
                    $("#thumbnail").html('<img src=\"' + data[0].summary.cover + '\" style=\"border:solid 1px #000000\" />');
                }
                $("#title").val(data[0].summary.title);
                $("#isbn").val(data[0].summary.isbn);
                $("#publisher").val(data[0].summary.publisher);
                $("#author").val(data[0].summary.author);
                $("#pubdate").val(data[0].summary.pubdate);
                $("#cover").val(data[0].summary.cover);
                $("#description").val(data[0].onix.CollateralDetail.TextContent[0].Text);
            }
        });
    });