# YouTubeCache
The YouTube Cache Problem by Google. Solved in some languages.

This problem was solved in 1h, 45 minutes, and 44 seconds.

Please don't expect documentation for the code. I'll document it on my own time, when I feel like it. 
If you want to, feel free to make a PR. 

Scores for PHP-YouTubeCache:

|Dataset   	            |Score   	|
|---	                |---	    |
|data                   |562,500    |
|kittens   	            |101,511   	|
|trending_today         |96,421   	|
|me_at_the_zoo          |436,097   	|
|videos_worth_spreading |81,853     |

Total score (including sample set): `1,278,382`.
Total score (excluding sample set): `715,882`.

Ways to improve this? (Ways I think this algorithm can be improved)
- Back Propagation: Currently, once we make a decision, we don't look back. This
can be bad for future decisions but is fastest way of going about it. Back Propagation
while slowing the algorithm down significantly, might lead to a higher score. Definitely
something one should explore.
