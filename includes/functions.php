<?php

  // Returns formated datetime string
  function get_date_string($datetime, $alttext, $format) {
    if (!is_null($alttext)) {
      return $alttext;
    }
    $datetime_obj = new DateTime($datetime);
    return $datetime_obj->format($format);
  }

?>