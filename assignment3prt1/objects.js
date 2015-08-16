/**
* Create an object literal with the following key value pairs:
* type: {string} 'Goldfish'
* brand: {string} 'Pepperidge Farm'
* flavor: {string} 'Cheddar'
* count: {number} 2000
* It should be returned directly by the following function
* @return {object} - the object literal
*/

function returnObjectLiteral() {
  //your code here

    /* put on one line because ONLY was emphasised and it scared me to do the normal layout */
    return ({ type: "Goldfish", brand: "Pepperidge Farm", flavor: "Cheddar", count: 2000 }); //Modify ONLY this line

  //end your code
}

/**
* Create a constructor function for a `MessageLog` object.
* @constructor
* @param {string} user - The user associated to the message log
* The string indicating the user should be stored in the user property of the
* object instances.
*
* In addition, the following methods should be
* callable on a MessageLog object:
* logMessage( {string} messageText, {number} direction) - This should log a
* message
* as either being sent or received. A direction of 0 indicates it is a message
* the user sent. A direction of 1 indicates it is a message the user received.
* Behavior for other numbers is undefined.
* getSentMessage({number} n) - returns as a string, the content of the nth most
* recently sent message. To conserve memory, the object should only keep the
* last 5 message. n=0 retrieves the most recent n=4 retrieves the least recent
* of the 5.
* totalSent() - returns an integer indicating the total number of messages sent
* totalReceived() - returns an integer indicating the total number of messages
* received
*/

//your code here
function MessageLog(user) {
    this.user = user;
    this.sent = 0;              // starting value of sent messages
    this.received = 0;          // starting value of received messages
    this.log = new Array();     // last five sent messages kept here
    this.recLog;                // will store last received message, and only the message. No array needed, since get is only position [0]
    this.logMessage = function (messageText, direction) {
        if (direction == 0) {
            this.sent++;                    // increase amount of sent message
            this.log.unshift(messageText);  // put in the new message in the beginning of the array
            if (this.log.length > 5)
                this.log.pop();              // make sure we don't overflow the array by getting rid of the oldest
        }
        else {
            this.received++;
            this.recLog = messageText;      // keep track of only the most recent received message;
        }
    };


    this.getSentMessage = function (n) {
        if (this.sent == 0) {
            console.log("Error: No messages");                // checking for empty array
        }

        if (n > 5) {
            console.log("Error: Only stores 5 messages");   // checking for valid input
        }
        else
            return this.log[n];
    };


    this.totalSent = function () {
        return this.sent;
    };


    this.totalReceived = function () {
        return this.received;
    };

}
//end your code

/**
* Add a method to the MessageLog prototype:
* lastReceivedMessage() - returns the message text of the last message the user
* received.
*/
//your code here
MessageLog.prototype.lastReceivedMessage = function () {
    if (this.received == 0) {
        console.log("Error: No received messages");         // check for empty array
    }
    else
        return this.recLog;
}
//end your code

/**
* Create an instance of a `MessageLog` for the user "BlackHatGuy". Have the
* instance receive 3 messages: "foo", "bar" and "baz", received in that order.
* Assign it to the variable myLog.
*/

//your code here
var myLog = new MessageLog("BlackHatGuy");
myLog.logMessage("foo", 1);
myLog.logMessage("bar", 1);
myLog.logMessage("baz", 1);
//end your code
