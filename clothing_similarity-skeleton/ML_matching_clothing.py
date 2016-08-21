import math
import os
from random import sample
import pandas as pd
import cPickle as pickle
import json

from scipy import spatial
import sys
from PIL import Image
import numpy as np
import indicoio

#indico API Key: 3a4fd542fc406583be1dd66a1567f6a4
indicoio.config.api_key = '3a4fd542fc406583be1dd66a1567f6a4'

# number of images to compare with input for match
N_IMG = 10

# number of images displayed
n_img_displayed = 10

def make_paths_list(count):
    d = []
    i = 0
    for root, dirs, files in os.walk("../clothing_similarity-skeleton/images"):
        for image in files:
            if image.endswith(".jpg"):
                d.append(os.path.join(root, image))
                i += 1
                if i == count:
                    return d


def make_feats(paths):
    feats = []
    for image in paths:
        feats.append(indicoio.image_features(image, batch=False))
    return feats

def calculate_sim(feats,count):
    distances = spatial.distance.pdist(np.matrix(feats), 'euclidean')
    m = []
    q = lambda i,j,n: n*(n-1)/2 - (n-i)*(n-i-1)/2 + j - i - 1
    for i in range(count):
        r = []
        for j in range(count):
            tup = (distances[q(i,j,count)], j)
            if i == j:
                tup = (0, j)
            r.append(tup)
        r = sorted(r, key=lambda x: x[0])
        m.append(r)
    return m

def similarity_image(chosen_img, similarity_matrix, paths):
    closestImages = []
    #new_img = Image.new('RGB', (995, 410), "#f8fafc")
    for i in range(len(paths)):
        im_num = similarity_matrix[chosen_img][i][1]
        path = paths[im_num]
        closestImages.append(path)
            #img = Image.open(path)
            #img.thumbnail((200, 200))
            #pos = ((i % 5) * 210, int(math.floor(i / 5.0) * 210))
            #new_img.paste(img, pos)
            #new_img.save('output/'+ str(N_IMG) + 'if' + str(chosen_img) + '.jpg')
    #new_img.show()
    return closestImages

def addFeatures(link):
    return np.array(indicoio.image_features(link, batch=False))

def main():
    print(sys.argv[1])
    matrix=None
    count = 0
    if (os.path.isfile('test.csv')):
        matrix =pd.read_csv('test.csv')
        paths = make_paths_list(len(matrix))
        matrix = matrix.drop('Unnamed: 0',axis=1)
    else:
        feats = make_feats(paths)
        matrix = pd.DataFrame(feats)

    newRow = addFeatures(sys.argv[1])
    paths.append(sys.argv[1])
    matrix.loc[len(matrix)] = newRow
    matrix.to_csv('test.csv')
    count = len(matrix)

    similarity_rankings = calculate_sim(matrix.values,count)
    print(len(similarity_rankings))

    chosen_img = len(matrix) -1
    result = similarity_image(chosen_img, similarity_rankings, paths)
    with open('outFile', 'w') as outfile:
        json.dump(result, outfile)
    return result

if __name__ == '__main__':
    main()











