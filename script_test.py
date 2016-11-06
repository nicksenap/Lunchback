# -*- coding: utf-8 -*-

from mysql.connector import (connection)

cnx = connection.MySQLConnection(user='lunchback', password='',
                              host='127.0.0.1',
                              database='vssf_core')
cursor = cnx.cursor()

# idlist_bak = [int(x) for x in input("> User ids: ").split()]
# idlist = [range(1,1000)]
idlist_bak = [660,106,1911,1485,592,1592,73,972,753,335,904,113,656,1369,637,578,376,2122,66,2226,75,2207]
idlist = [660,106,1911,1485,592,1592,73,972,753,335,904,113,656,1369,637,578,376,2122,66,2226,75,2207]
# idlist_bak = [1,2,3,4]
# target_list = [[2],[4],[3],[1]]
target_list = []
result_list = []

for id in idlist_bak:
	query = ("SELECT masterId, concat(lunchback_user_profiles.first_name,' ',lunchback_user_profiles.last_name) as masterName, lunchback_user_profiles.headline, lunchback_user_profiles.base_city as masterLocation ,candidateId FROM ( SELECT masterId,candidateId FROM ( SELECT DISTINCT t1.user_id as masterId, concat(p1.first_name,' ',p1.last_name) as masterName, p1.headline,p2.id as candidateId FROM lunchback_user_tags t1 JOIN lunchback_user_tags t2, lunchback_user_profiles p1 JOIN lunchback_user_profiles p2 WHERE t2.user_id = %d AND t1.user_id != t2.user_id AND t1.tag_type = 'offering' AND t2.tag_type = 'searching' AND t1.tag = t2.tag AND p1.id = t1.user_id AND p2.id = t2.user_id AND t2.tag = t1.tag AND p1.base_city = p2.base_city AND p1.removed = 0 AND p2.removed = 0 AND t1.removed = 0 AND t2.removed = 0 UNION SELECt DISTINCT h1.target_id as masterId , concat(p.first_name,' ',p.last_name) as masterName, p.headline,h1.user_id as candidateId FROM lunchback_view_history h1, lunchback_view_history h2,lunchback_user_profiles p WHERE h1.user_id = %d AND h2.user_id = h1.target_id AND h2.target_id = h1.user_id AND p.id = h1.target_id) AS FOO )AS FAK INNER JOIN lunchback_user_interested_user ON masterId = lunchback_user_interested_user.user_id,lunchback_user_profiles WHERE candidateId = target_id AND masterId = lunchback_user_profiles.id UNION SELECt DISTINCT h1.target_id as masterId , concat(p.first_name,' ',p.last_name) as masterName, p.headline, p.base_city as masterLocation, h1.user_id as candidateId FROM lunchback_view_history h1, lunchback_view_history h2,lunchback_user_profiles p WHERE h1.user_id = %d AND h2.user_id = h1.target_id AND h2.target_id = h1.user_id AND p.id = h1.target_id AND h1.user_id != h1.target_id") %(id,id,id)
	temp_list = []
	cursor.execute(query, id)
	for (masterId, masterName,headline,masterLocation,candidateId) in cursor:
		temp_list.append(masterId)
	target_list.append(temp_list)

#print(idlist_bak)

try:
	for sublist in target_list:
		for i in range(len(sublist)):
			if sublist[i] in idlist_bak:
				print("--------------------------------------")
				index = target_list.index(sublist)
				# print(sublist[i], idlist_bak[index])
				result_list.append([idlist_bak[index], sublist[i]])
				print(idlist_bak[index]," removed from idlist")
				print(sublist[i]," removed from sublist")
				idlist_bak.remove(idlist_bak[index])
				idlist_bak.remove(sublist[i])
				print(idlist_bak)
				print(result_list)
			else:
				pass 
except IndexError:
	print("Left: ", idlist_bak)
print("Paired: ", result_list)

# print(target_list)


# for i in range(len(target_list)):
#	if len(target_list[i]) > 0:
#		lamda = (target_list[i],idlist[i])
#		print(lamda)
#
		
		# print(type(lamda[0]))


# print(target_list)	


cursor.close()
cnx.close()