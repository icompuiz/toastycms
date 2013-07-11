/**
 * ListItemState allows a list item to track its state between sessions
 * @param {hash} options - hash of required parameters.
 * @param {string} options.identifier - the identifier for the list item
 * @returns {ListItemState}
 * 
 */
function ListItemState(options) {
    
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
        
        var item_states_string = localStorage.getItem('item_states') || "{}";
        
        var item_states = JSON.parse(item_states_string);
        
        return item_states;
        
    }
    
    /**
     * writeLocalStorage
     * Takes a hash of all item_states and writes it to local storage
     * @param {hash} item_states
     */
    
    function writeLocalStorage(item_states) {
        item_states_string = JSON.stringify(item_states);
        
        localStorage.setItem('item_states', item_states_string);
    } 
    
    /**
     * set
     * Sets the item's current state in local storage
     * @param {type} state
     */
    
    this.set = function(state) {
        
        var item_states = readLocalStorage();
        
        var item_state = {
            id: settings.identifier,
            state: state
        };
        
        item_states[settings.identifier] = item_state;
                
        writeLocalStorage(item_states);
        
    };
    
    /**
     * get
     * Retreives the item's last know state from local storage
     * @param {type} state
     */
    
    this.get = function() {
        
        var item_states = readLocalStorage();
        
        if (item_states) {
                    
            var current_state = item_states[settings.identifier];
            
            if (current_state) {
                return current_state.state;
            }
        }
        
        return "0";

    };
    
    this.state = this.get();

    
}
