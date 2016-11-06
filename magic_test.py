# -*- coding: utf-8 -*-

idlist = [1,2,3,4]
idlist_bak = [1,2,3,4]
target_list = [[2],[4],[3],[1]]
# target_list = []
result_list = []
pointer = 0

while pointer < len(idlist):
	pass
	for sublist in target_list:
		idlist_pointed = idlist_bak[pointer]
		for i in range(len(sublist)):
			if sublist[i] == idlist_pointed:
				result_list.append([sublist[i], idlist_pointed])
				idlist_bak.remove(idlist_pointed)
				idlist_bak.remove(idlist_bak[target_list.index(sublist)])
				pointer+=1
				print("--------------------------------------")		
			else:
				pass 


print(target_list)


# for i in range(len(target_list)):
#	if len(target_list[i]) > 0:
#		lamda = (target_list[i],idlist[i])
#		print(lamda)
#
		
		# print(type(lamda[0]))


# print(target_list)	

