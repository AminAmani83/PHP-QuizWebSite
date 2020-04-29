$(document).ready(function () {

    // define vars for re-use
    const userInputField = $("#user-input input[name='user-answer']");

    // 1. focus on the input field
    userInputField.focus();

    // 2. live timer + timeOut action
    if ($("#title-bar button[name='btn-giveup']").length) { // giveup button exists => game is active
        const timerSpanElem = $("#timer");
        const timeArray = timerSpanElem.text().split(":");
        let timeLeft = parseInt(timeArray[0]) * 60 + parseInt(timeArray[1]);
        const timerId = setInterval(tick, 1000);

        function tick() {
            timeLeft--;
            if (timeLeft < 0) {
                clearInterval(timerId);
                $("#user-input button[name='btn-next']").click(); // if timeout, simulate btn-next click to end the game
            } else {
                timerSpanElem.text(Math.floor(timeLeft / 60) + ":" + ("0" + (timeLeft % 60)).slice(-2));
                if (timeLeft < 10) { // red timer text
                    timerSpanElem.addClass("text-danger bold-text");
                }
            }
        }
    }

    // 3. JavaScript Assist Mode: If Input is correct, the color changes to green
    if (typeof answer !== 'undefined') { // the correct answer is passed to js
        userInputField.keyup(function (event) {
            if (cleanUpString(event.target.value) === cleanUpString(decrypt(answer, 1))) {
                userInputField.addClass("text-success");
                userInputField.removeClass("text-dark");
            } else {
                userInputField.addClass("text-dark");
                userInputField.removeClass("text-success");
            }
        });
    }


    // Functions

    /**
     * Remove non-alphanumeric chars from a string and convert it to lowercase
     * to prepare it for comparison with other strings (should be the same as the server-side logic)
     * @param str string to be cleaned up
     * @returns {string} cleaned up string
     */
    function cleanUpString(str) {
        return str.replace(/\W+/g, '').toLowerCase();
    }

    /**
     * Calculating the de-ciphered version of a word using the Caesar Cipher algorithm
     * Source: https://learnersbucket.com/examples/algorithms/caesar-cipher-in-javascript/
     * @param str
     * @param key
     * @returns {string}
     */
    function decrypt(str, key) {
        let decipher = '';
        for (let i = 0; i < str.length; i++) {
            decipher += String.fromCharCode((str.charCodeAt(i) - key) % 255);
        }
        return decipher;
    }

});