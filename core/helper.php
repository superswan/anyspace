<?php 
function login_check() {
    if (!isset($_SESSION['user'])) {
        header("Location: /login.php");
        exit;
    }
}

function validateContentHTML($validate) {
    // Whitelisted tags
    $allowedTags = '<a><b><big><blockquote><blink><br><center><code><del><details><div><em><font><h1><h2><h3><h4><h5><h6><hr><i><iframe><img><li><mark><marquee><ol><p><pre><small><span><strong><style><sub><summary><sup><table><td><th><time><tr><u><ul>';


    // Remove script tags
    $validated = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $validate);
    
    // Remove PHP blocks
    $validated = preg_replace('/<\?php(.*?)\?>/is', '', $validated);

    // Remove any remaining PHP short tags
    $validated = preg_replace('/<\?(?!php)(.*?)\?>/is', '', $validated);
    
    // Remove behavior: url()
    $validated = str_replace("behavior: url", "", $validated);
    
    // Remove any remaining HTML tags except the allowed ones
    $validated = strip_tags($validated, $allowedTags);

    return $validated;
}

function validateLayoutHTML($validate) {
    // Whitelisted tags
    $allowedTags = '<style><img><div><iframe><a><h1><h2><h3><p><ul><ol><li><blockquote><code><em><strong><br>';

    // Remove script tags
    $validated = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $validate);
    
    // Remove PHP blocks
    $validated = preg_replace('/<\?php(.*?)\?>/is', '', $validated);

    // Remove any remaining PHP short tags
    $validated = preg_replace('/<\?(?!php)(.*?)\?>/is', '', $validated);
    
    // Remove behavior: url()
    $validated = str_replace("behavior: url", "", $validated);
    
    // Remove any remaining HTML tags except the allowed ones
    $validated = strip_tags($validated, $allowedTags);

    return $validated;
}

// thanks dzhaugasharov https://gist.github.com/afsalrahim/bc8caf497a4b54c5d75d
function replaceBBcodes($text) {
    $text = htmlspecialchars($text);
    // BBcode array
    $find = array(
        '~\[b\](.*?)\[/b\]~s',
        '~\[i\](.*?)\[/i\]~s',
        '~\[u\](.*?)\[/u\]~s',
        '~\[quote\]([^"><]*?)\[/quote\]~s',
        '~\[size=([^"><]*?)\](.*?)\[/size\]~s',
        '~\[color=([^"><]*?)\](.*?)\[/color\]~s',
        '~\[url\]((?:ftp|https?)://[^"><]*?)\[/url\]~s',
        '~\[img\](https?://[^"><]*?\.(?:jpg|jpeg|gif|png|bmp))\[/img\]~s'
    );
    // HTML tags to replace BBcode
    $replace = array(
        '<b>$1</b>',
        '<i>$1</i>',
        '<span style="text-decoration:underline;">$1</span>',
        '<pre>$1</pre>',
        '<span style="font-size:$1px;">$2</span>',
        '<span style="color:$1;">$2</span>',
        '<a href="$1">$1</a>',
        '<img src="$1" alt="" />'
    );
    // Replacing the BBcodes with corresponding HTML tags
    return preg_replace($find, $replace, $text);
}

function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    // Calculate weeks as a separate variable using days
    $weeks = floor($diff->d / 7);
    $diff->d -= $weeks * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );

    if ($weeks) {
        $string = array_merge(array('w' => 'week'), $string); 
    }

    foreach ($string as $k => &$v) {
        $value = ($k === 'w') ? $weeks : $diff->$k; 
        if ($value) {
            $v = $value . ' ' . $v . ($value > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}