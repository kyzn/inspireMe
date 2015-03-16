Run setup.sql on your local MySql. Database relationship should look like below.

![](http://i.imgur.com/7Oxol2n.png)

A few notes:

 * There are many 'on update cascade on delete cascade' relations. That means, for example, if a community is deleted, then all posts that belong to that community (and all comments under these posts) will be deleted as well.
 * We'd need isDeleted for upvote tables, this is to prevent misuse of the date-based algorithm. To be more precise, if we utilize an algoritm that depends on the date upvote is given to calculate rank of a post/comment, then some users might just delete their upvotes and give upvote over and over again. This is obviously harmful.