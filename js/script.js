$(document).ready(function() {
    $("#LoadingSimpan").click(function() {
        // disable button
        $(this).prop("disabled", true);
        // add spinner to button
        $(this).html(
            '<i class="fa fa-circle-o-notch fa-spin"></i> Menyimpan'
        );

    setTimeout(function() {
        document.getElementById('form-1').submit();
    },1000)
    });
});

$(document).ready(function() {
    $("#LoadingSimpan2").click(function() {
        // disable button
        $(this).prop("disabled", true);
        // add spinner to button
        $(this).html(
            '<i class="fa fa-circle-o-notch fa-spin"></i> Menyimpan'
        );

    setTimeout(function() {
        document.getElementById('form-2').submit();
    },1000)
    });
});

$(document).ready(function() {
    $("#LoadingSimpan3").click(function() {
        // disable button
        $(this).prop("disabled", true);
        // add spinner to button
        $(this).html(
            '<i class="fa fa-circle-o-notch fa-spin"></i> Menyimpan Hasil Akhir'
        );

    setTimeout(function() {
        document.getElementById('form-3').submit();
    },3000)
    });
});

$(document).ready(function() {
    $("#loadinglogin").click(function() {
        // disable button
        $(this).prop("disabled", true);
        // add spinner to button
        $(this).html(
            '<i class="fa fa-circle-o-notch fa-spin"></i> Login'
        );

    setTimeout(function() {
        document.getElementById('form-login').submit();
    },1000)
    });
});

$(document).ready(function() {
    const mySelect = document.getElementById("textSelect");
    const inputOther = document.getElementById("form12");
    const labelInput = document.getElementById("inputLabel");
    const divInput = document.getElementById("inputDiv");
    const selectDiv = document.getElementById("textSelectdiv");

    mySelect.addEventListener('optionSelect.mdb.select', function(e){
        const SelectValue = document.getElementById('textSelect').value;
        if (SelectValue === 'customOption') {
            inputOther.style.display='inline';
            inputOther.removeAttribute('disabled');
            labelInput.classList.remove('disaplayInput');
            divInput.classList.remove('disaplayInput');
            selectDiv.style.display='none';
            inputOther.focus();
            mySelect.disabled = 'true';

        } else {
            a.style.display='none';
        }
    })

    function hideInput(){
        if (inputOther !== null && inputOther.value === "")
            {
        inputOther.style.display='none';
        inputOther.setAttribute('disabled', '');
        selectDiv.style.display='inline';
        mySelect.removeAttribute('disabled');
        labelInput.classList.add('disaplayInput');
        divInput.classList.add('disaplayInput');
            }
    }
});