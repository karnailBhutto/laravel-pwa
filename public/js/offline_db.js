function openIndexedDBDatabase() {

	let db;
	let dbReq = indexedDB.open('sfa-kh', 1);
	dbReq.onupgradeneeded = function(event) {
	  // Set the db variable to our database so we can use it!  
	  db = event.target.result;
	  let outlets = db.createObjectStore('outlets', {autoIncrement: true});
	}
	// dbReq.onsuccess = function(event) {
	  // db = event.target.result;
	// }
	
	dbReq.onsuccess = function(event) {
	  db = event.target.result;
	  // Add some sticky notes
	  addStickyNote(db, 'Sloths are awesome!');
	  addStickyNote(db, 'Order more hibiscus tea');
	  addStickyNote(db, 'And Green Sheen shampoo, the best for sloth fur algae grooming!');
	}
	
	dbReq.onerror = function(event) {
	  alert('error opening database ' + event.target.errorCode);
	}
	
	function addStickyNote(db, message) {
	  // Start a database transaction and get the notes object store
	  let tx = db.transaction(['outlets'], 'readwrite');
	  let store = tx.objectStore('outlets');
	  // Put the sticky note into the object store
	  let note = {text: message, timestamp: Date.now()};
	  store.add(note);
	  // Wait for the database transaction to complete
	  tx.oncomplete = function() { console.log('stored note!') }
	  tx.onerror = function(event) {
		alert('error storing note ' + event.target.errorCode);
	  }
	}

}