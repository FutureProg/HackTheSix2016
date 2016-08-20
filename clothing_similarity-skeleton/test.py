import os
import indicoio
import cPickle as pickle

from scipy import spatial
import numpy as np

#indico API Key: 3a4fd542fc406583be1dd66a1567f6a4
indicoio.config.api_key = '3a4fd542fc406583be1dd66a1567f6a4'

n_img = 10

def make_paths_list():
	paths = []
	i = 0
	for root, dirs, files in os.walk("images"):
	    for image in files:
	    	if image.endswith(".jpg"):
	    		i += 1
	    		if i <= n_img:
	    			paths.append(os.path.join(root, image))
	return paths

paths = pickle.load(open('paths.pkl', 'rb'))
paths = make_paths_list()
pickle.dump(paths, open('paths.pkl', 'wb'))
feats = []
for image in paths:
	feats.append(indicoio.image_features(image, batch=False))
print len(feats)
distances = spatial.distance.pdist(np.matrix(feats), 'euclidean')

m = []
q = lambda i,j,n: n*(n-1)/2 - (n-i)*(n-i-1)/2 + j - i - 1
for i in range(n_img):
    r = []
    for j in range(n_img):
        tup = (distances[q(i,j,n_img)], j)
        if i == j:
            tup = (0, j)
        r.append(tup)
    r = sorted(r, key=lambda x: x[0])
    m.append(r)
print m

for i in range(10):
    im_num = m[3][i][1]
    print im_num