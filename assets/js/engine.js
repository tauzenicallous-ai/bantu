//mangoma depot levels ribhee na fantaan
//copyright nightwatch productions
//č 2015-2025



function get_h1Data() {

    let dataString= 'placeholder=placeholder';


    $.ajax({
        type: "POST",
        url: "ajax_handlers/for_index/get_bank_accounts.php",
        data: dataString,
        dataType: 'json',
        cache: false,
        success: function(dataBack) {

            let html= dataBack.html;
            let number_of_accounts= dataBack.number_of_accounts;
            let number_of_countries= dataBack.number_of_countries;
            let total_cumulative_balance= dataBack.total_cumulative_balance;

            $('#cumulative_bank_balance').data('amount',total_cumulative_balance);
            $('#number_of_accounts').text(number_of_accounts);
            $('#number_of_countries').text(number_of_countries);

            document.getElementById('currency_balances').innerHTML= html;

        },

    });



    return false;
}







