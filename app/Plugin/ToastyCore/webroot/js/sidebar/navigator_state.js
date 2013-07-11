/**
 * ListItemState allows a list item to track its state between sessions
 * @param {hash} options - hash of required parameters.
 * @param {string} options.identifier - the identifier for the list item
 * @returns {NavigatorState}
 * 
 */
function NavigatorState(options) {
    
    var settings = {
        identifier: "unknown"
    };
    
    $.extend(settings, options);
    
    /**
     * readLocalStorage
     * reads local storage and returns a hash of all item states
     * @returns the hash of all item states in local storage
     */
    
    function readLocalStorage() {
        
        var navigator_states_string = localStorage.getItem('navigator_states') || "{}";
        
        var navigator_states = JSON.parse(navigator_states_string);
        
        return navigator_states;
        
    }
    
    /**
     * writeLocalStorage
     * Takes a hash of all navigator_states and writes it to local storage
     * @param {hash} navigator_states
     */
    
    function writeLocalStorage(navigator_states) {
        navigator_states_string = JSON.stringify(navigator_states);
        
        localStorage.setItem('navigator_states', navigator_states_string);
    } 
    
    /**
     * set
     * Sets the item's current state in local storage
     * @param {type} state
     */
    
    this.set = function(state) {
        
        var navigator_states = readLocalStorage();
        
        var navigator_state = {
            id: settings.identifier,
            state: state
        };
        
        navigator_states[settings.identifier] = navigator_state;
                
        writeLocalStorage(navigator_states);
        
    };
    
    /**
     * get
     * Retreives the item's last know state from local storage
     * @param {type} state
     */
    
    this.get = function() {
        
        var navigator_states = readLocalStorage();
        
        if (navigator_states) {
                    
            var current_state = navigator_states[settings.identifier];
            
            if (current_state) {
                return current_state.state;
            }
        }
        
        return null;

    };
    
    this.state = this.get();

    
}
