/**
 * @file
 * JS file to triggering Toastify.
 */

(function () {

  Drupal.toastify = {};

  Drupal.toastify.getDefaultSettings = function (type) {
    var displaySettings = drupalSettings.toastify.settings;

    return {
      duration: displaySettings[type].duration,
      gravity: displaySettings[type].gravity,
      positionLeft: displaySettings[type].positionLeft,
      close: displaySettings[type].close,
      backgroundColor: 'linear-gradient(' + displaySettings[type].direction + ', ' + displaySettings[type].color + ', ' + displaySettings[type].color2 + ')',
      escapeMarkup: false,
      className: `toastify--${type}`,
      progressBar: true,
      progressBarColor: displaySettings[type].colorProgressBar,
    };
  };

  Drupal.behaviors.toastify = {
    attach: function (context, drupalSettings) {
      if (!drupalSettings.toastify || !drupalSettings.toastify.messages) {
        return;
      }

      for (const [type, messages] of Object.entries(drupalSettings.toastify.messages)) {
        for (const message of messages) {
          const toastifySettings = Drupal.toastify.getDefaultSettings(type);
          toastifySettings.text = message;

          Toastify(toastifySettings).showToast();
        }
      }

      drupalSettings.toastify.messages = [];
    }
  }

})();
