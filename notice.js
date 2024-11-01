(function($) {

  window.addEventListener(
    'load',
    function() {

      // Go back from sirat theme installation START
      if ( location.href.indexOf("vw-notes-files-downloader-sirat-installed=true") >= 0 ) {

        // Select the node that will be observed for mutations
        const targetNode = document.querySelector('.wrap');

        // Options for the observer (which mutations to observe)
        const config = { attributes: true, childList: true, subtree: true };

        // Callback function to execute when mutations are observed
        const callback = function( mutationsList, observer ) {
          // Use traditional 'for loops' for IE 11
          for( const mutation of mutationsList ) {
            if ( mutation.type === 'childList' ) {
            }
            else if (mutation.type === 'attributes') {
            }

            if ( jQuery( '.wrap a[href*="themes.php"]' ).length ) {
              // window.history.back();
              location.href = vw_notes_files_downloader_notice_script_params.admin_url + 'plugins.php';
            }
          }
        };

        // Create an observer instance linked to the callback function
        const observer = new MutationObserver(callback);

        // Start observing the target node for configured mutations
        observer.observe(targetNode, config);

        // Later, you can stop observing
        // observer.disconnect();

      }
      // Go back from sirat theme installation END

    },
    false
  );





})( jQuery );
