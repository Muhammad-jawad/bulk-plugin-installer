 jQuery(document).ready(function($)
 {

    // On submit of Form
    $("#upload_plugin_form").submit( function(submitEvent) 
    {
      var selection = document.getElementById('bulk_plugin_installer_locFiles');
      var ext = "zip";
      // Check if input is not empty
      if(selection.files.length == 0)
      {
        alert('Please select file before submiting Install & Activate Plugins button');
        return false
      }
      // Loop on All files
      for (var i=0; i<selection.files.length; i++) 
      {
          var fileExtension = selection.files[i].name.substr(-3);
          // If extension is not .zip
          if(fileExtension !== ext)  
          {
              alert('Please upload .zip extension files.');
              return false;
          }
          else
          {
            return true;       
          }
      } 
    });


    /* 
    *
    * Drag & Drop Input Script
    *
    */

      var $fileInput = $('.file-input');
      var $droparea = $('.file-drop-area');

      // highlight drag area
      $fileInput.on('dragenter focus click', function() 
      {
        $droparea.addClass('is-active');
      });

      // back to normal state
      $fileInput.on('dragleave blur drop', function() 
      {
        $droparea.removeClass('is-active');
      });

      // change inner text
      $fileInput.on('change', function() 
      {
        var filesCount = $(this)[0].files.length;
        var $textContainer = $(this).prev();

        if (filesCount === 1) 
        {
          // if single file is selected, show file name
          var fileName = $(this).val().split('\\').pop();
          $textContainer.text(fileName);
        } else 
        {
          // otherwise show number of files
          $textContainer.text(filesCount + ' files selected');
        }
      });


      /*
      * Show Files List and Update
      */

      const dt = new DataTransfer(); // Allow to manipulate the files of the input file

      $("#bulk_plugin_installer_locFiles").on('change', function(e){
        for(var i = 0; i < this.files.length; i++){
          let fileBloc = $('<span/>', {class: 'file-block'}),
             fileName = $('<span/>', {class: 'name', text: this.files.item(i).name});
          fileBloc.append('<span class="file-delete"><span>+</span></span>')
            .append(fileName);
          $("#filesList > #files-names").append(fileBloc);
        };
        // Addition of the files in the object DataTransfer
        for (let file of this.files) {
          dt.items.add(file);
        }
        // Update of the files of the input file after addition
        this.files = dt.files;

        // EventListener for delete button created
        $('span.file-delete').click(function(){
          let name = $(this).next('span.name').text();
          // Supprimer l'affichage du nom de fichier
          $(this).parent().remove();
          for(let i = 0; i < dt.items.length; i++){
            // Match file and name
            if(name === dt.items[i].getAsFile().name){
              // Deleting file in DataTransfer object
              dt.items.remove(i);
              $('.file-drop-area span.file-msg').text(dt.items.length + ' files selected');
              continue;
            }
          }
          // Updating input file files after deletion
          document.getElementById('bulk_plugin_installer_locFiles').files = dt.files;
        });
      });
});