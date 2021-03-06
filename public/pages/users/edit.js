window.addEvent('domready', function() {

	new FormValidator($('userEditForm'), "Successfully updated user information, redirecting to home page...",
		{
			redirect: false,
			redirectURL: "/users/view/"
		}
	);

    // go back to the users home page
    $('cancel').addEvent('click', function(e) {
        e.preventDefault();
        new StickyWinModal({
            content: StickyWin.ui('Cancel changes',
                "Are you sure you want to cancel, any changes you have not saved will be lost?", {
                    width: '400px',
                    buttons: [
                        {
                            text: 'Yes',
                            onClick: function() {
                                window.location = "/users/view";
                            }
                        },
                        {
                            text: 'No',
                            onClick: function() {
                                // ignore
                            }
                        }
                    ]
                })
        });
    });

});	
