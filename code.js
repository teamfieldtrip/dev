(function ($) {
  'use strict'

  var setCountdown = function (data) {
    var goal = new Date(data.date)

    $('[data-content=countdown]').countdown({
      since: goal,
      format: 'YOWDHMS',
      description: 'Since the last CI failure'
    })
  }

  var init = function () {
    $.get('/time.php', setCountdown)
  }

  $(document).ready(init)
}(jQuery))
