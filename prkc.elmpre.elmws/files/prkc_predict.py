#!/usr/bin/env python
#This tool allow users to predict phophorylation site from data
from svmutil import *
from sys import argv, platform
from os import path, popen


#get the predict data
def get_pos_deci(train_y, train_x, test_y, test_x, param):
	model = svm_train(train_y, train_x, param)
	#predict and grab decision value, assure deci>0 for label+,
	#the positive descision value = val[0]*labels[0]
	labels = model.get_labels()
	py, evals, deci = svm_predict(test_y, test_x, model)
	deci = [labels[0]*val[0] for val in deci]
	return deci
	
def peptide(a,b,c,d): ##a-position;b-range;c-full_length;d-protein_sequence
	pep = ""   ##先要定义空字符
	for i in range((a-b-1),(a+b),1):
		if (i<0 or i>c-1):
			pep += "A"
		else:
			pep += d[i]
	return pep
	
def t_peptide(fasta_file):
	import itertools
	import re
	pep = open('./output_file/test.txt',"w")                     ###一个文件名需要注意
	with open(fasta_file) as f:
		for line1,line2 in itertools.izip_longest(*[f]*2):
			line1 =line1.strip('\n')
			line2 =line2.strip('\n')
			line2_l = len(line2)
			#print line2_l
			for i in range(1,line2_l+1):
				result1 = peptide(i,15,line2_l,line2)
				if re.match('[A-Z]{15}[ST][A-Z]{15}',result1):
					pep.write(result1 + "\t" + line1 + "_" + str(i) + "\n")
	pep.close()
	
def fastaR2score(train_peptide, test_peptide):  
	n = 0
	m = 0
	p_symbol = {}
	n_symbol = {}
	list1 = ['A','Q','W','E','R','T','Y','U','I','O','P','S','D','F','G','H','J','K','L','Z','X','C','V','B','N','M']
	for i in list1:
		for j in range(31):
			p_symbol[i + str(j)] = 0
			n_symbol[i + str(j)] = 0
	with open(train_peptide) as t:     #for example
		for line in t.readlines():
			line =line.strip('\n')
			data = line.split('\t')
			peptide = data[0]
			mi = len(peptide)
			if data[1] == '1':
				n += 1
				for i in range(mi):
					p_symbol[peptide[i] + str(i)] += 1
			if data[1] == '-1':
				m += 1
				for i in range(mi):
					n_symbol[peptide[i] + str(i)] += 1
	testout = open('./output_file/testscore',"w")                 #文件路径要改
	with open(test_peptide) as t:
		tpep = []
		tpro = []
		for line in t.readlines():
			line =line.strip('\n')
			temp = line.split('\t')
			tpep.append(temp[0])
			tpro.append(temp[1])
			peptide = temp[0]
			data = []
			for i in range(63):
				data.insert(i,0)
			data[0] = '1'
			for i in range(mi):
				j = i + 1
				k = i + 32
				data[j] = p_symbol[peptide[i] + str(i)] / float(n)
				data[k] = n_symbol[peptide[i] + str(i)] / float(m)
				data[j] = str(j) + ":" + str(data[j])
				data[k] = str(k) + ":" + str(data[k])
			result = " ".join(data)
			testout.write(result + "\n")
	testout.close()
	return tpep, tpro
	
	
#processing argv and set some global variables
def proc_argv(argv = argv):
	train_file = argv[-1]
	train_peptide_file = argv[-2]
	cut_off = None
	options = []
	i = 1
	while i < len(argv)-2:
		if argv[i] == '-T': 
			test_file = argv[i+1]
			i += 1
		elif argv[i] == '-l':
			cut_off = argv[i+1]
			i + 1
		else :
			options += [argv[i]]
		i += 1

	return ' '.join(options), train_peptide_file, train_file, test_file, cut_off
	
def main():
	if len(argv) <= 1:
		print("Usage: %s -T testing_file -l l/m/h [libsvm-options] train_peptide_file training_file" % argv[0])    ###注意输入文件路径
		raise SystemExit
	param,train_peptide_file,train_file,test_file, cut_off = proc_argv()
	t_peptide(test_file)
	test_peptide = './output_file/test.txt'                            ###和上面一致
	t_pep, t_pro = fastaR2score(train_peptide_file, test_peptide)
	test_svm = 	'./output_file/testscore'                              ###和上面一致
	#read data
	train_y, train_x = svm_read_problem(train_file)
	test_y, test_x = svm_read_problem(test_svm)
	deci = get_pos_deci(train_y, train_x, test_y, test_x, param)
	if cut_off == 'low':
		cut = ???
	elif cut_off == 'medium':
		cut = ???
	elif cut_off == 'high':
		cut_off = ???
	else:
		cut_off = ???
	deci_l = len(deci)
	for i in range(deci_l):
		if deci[i] >= cut_off:
			return t_pro[i];t_pep[i];deci[i]


if __name__ == '__main__':
	main()	