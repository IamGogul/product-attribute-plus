export default class PublicWPAPUtils {

    constructor(options) {
        this.options = $.extend(true, {
        }, options );
    }

    _console( $arg ) {
        console.log( $arg );
    }

    _isBool($arg ) {
        switch( $arg ) {
            case true:
            case "true":
            case "TRUE":
            case 1:
            case "1":
            case "on":
            case "ON":
            case "yes":
            case "YES":
                return true;

            default:
                return false;
        }
    }

    _setState($ele, $state) {
        $($ele).addClass($state);
    }

    _setStateAndSiblings($ele, $state) {
        return $($ele).addClass($state).siblings();
    }

    _removeState($ele, $state) {
        $($ele).removeClass($state);
    }

    _hasState( $ele, $state ) {
        return $($ele).hasClass($state);
    }

    _toggleState($ele, $state) {
        $($ele).toggleClass($state);
    }

    _setCookie( $name, $value, $days, $secureFlag = false, $sameSiteFlag = 'None' ) {
        var $expires = "";
        var $days    = $days ? $days : 7;

        console.log( $days );
        console.log( $secureFlag );
        console.log( $sameSiteFlag );

        if( $days ) {
            var date = new Date();
            date.setTime(date.getTime() + ($days * 24 * 60 * 60 * 1000));
            $expires = "; expires=" + date.toUTCString();
        }

        // Add Secure attribute if the secureFlag is true
        var $secureAttribute = $secureFlag ? '; Secure' : '';

        // Add SameSite attribute
        var $sameSiteAttribute = `; SameSite=${$sameSiteFlag}`;

        document.cookie = $name + "=" + $value + $expires + "; path=/" + $secureAttribute + $sameSiteAttribute;
    }

    _getCookie( $name ) {
        var nameEQ  = $name + "=";
        var cookies = document.cookie.split(';');

        for (var i = 0; i < cookies.length; i++) {
            var cookie = cookies[i];
            while (cookie.charAt(0) == ' ') {
                cookie = cookie.substring(1, cookie.length);
            }
            if (cookie.indexOf(nameEQ) == 0) {
                return cookie.substring(nameEQ.length, cookie.length);
            }
        }
        return null;
    }

}