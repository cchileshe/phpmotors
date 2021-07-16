
/* 1. Insert the following new client to the clients table:
Tony, Stark, tony@starkent.com, Iam1ronM@n, "I am the real Ironman" */

INSERT INTO clients (clientFirstname, clientLastname, clientEmail,clientPassword, comments)
VALUES ('Tony', 'Stark', 'tony@starkent.com', 'Iam1ronM@n', "I am the real Ironman");


/* 2. Modify the Tony Stark record to change the clientLevel to 3.*/

UPDATE clients
SET clientLevel = 3
WHERE clientId = 1;


/* 3. Modify the "GM Hummer" record to read "spacious interior" rather than "small interior" using a single query.  */

Update inventory
Set    invDescription = replace(invDescription, 'small interior', 'spacious interior')
WHERE  invId = 12;


/* 4. Use an inner join to select the invModel field from the inventory table and the classificationName 
field from the carclassification table for inventory items that belong to the "SUV" category. */

SELECT i.invModel, c.classificationName
FROM inventory i
INNER JOIN carclassification c
ON i.classificationId = c.classificationId
WHERE c.classificationId = 1
;


/* 5. Delete the Jeep Wrangler from the database. */

DELETE FROM inventory 
WHERE invId = 1;


/* 6. Update all records in the Inventory table to add "/phpmotors" to the beginning of the file path in the 
invImage and invThumbnail columns using a single query. */

UPDATE inventory
SET invImage = concat("/phpmotors",invImage), invThumbnail = concat("/phpmotors",invThumbnail)
;

