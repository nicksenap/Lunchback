# -*- coding: utf-8 -*-
# import datetime

from mysql.connector import (connection)

cnx = connection.MySQLConnection(user='lunchback', password='',
                              host='127.0.0.1',
                              database='vssf_core')
cursor = cnx.cursor()


idlist = [660, 106, 1911, 1485, 592, 1592, 73, 972, 753, 335, 904, 113, 656, 1369, 637, 578, 376, 2122, 66, 2226, 75, 2207]
idlist_bak = [660, 106, 1911, 1485, 592, 1592, 73, 972, 753, 335, 904, 113, 656, 1369, 637, 578, 376, 2122, 66, 2226, 75, 2207]
idlist2 = []
idlist3 = []
idlist4 = []
target_list = []
t_list = []
result_list = []
left_over = []
remove_list = []
rm_list_2 = []
rm_list_3 = []
rm_list_4 = []
rm_list_5 = []

for id in idlist:
	query = ("SELECT masterId, concat(lunchback_user_profiles.first_name,' ',lunchback_user_profiles.last_name) as masterName, lunchback_user_profiles.headline, lunchback_user_profiles.base_city as masterLocation ,candidateId FROM ( SELECT masterId,candidateId FROM ( SELECT DISTINCT t1.user_id as masterId, concat(p1.first_name,' ',p1.last_name) as masterName, p1.headline,p2.id as candidateId FROM lunchback_user_tags t1 JOIN lunchback_user_tags t2, lunchback_user_profiles p1 JOIN lunchback_user_profiles p2 WHERE t2.user_id = %d AND t1.user_id != t2.user_id AND t1.tag_type = 'offering' AND t2.tag_type = 'searching' AND t1.tag = t2.tag AND p1.id = t1.user_id AND p2.id = t2.user_id AND t2.tag = t1.tag AND p1.base_city = p2.base_city AND p1.removed = 0 AND p2.removed = 0 AND t1.removed = 0 AND t2.removed = 0 UNION SELECt DISTINCT h1.target_id as masterId , concat(p.first_name,' ',p.last_name) as masterName, p.headline,h1.user_id as candidateId FROM lunchback_view_history h1, lunchback_view_history h2,lunchback_user_profiles p WHERE h1.user_id = %d AND h2.user_id = h1.target_id AND h2.target_id = h1.user_id AND p.id = h1.target_id) AS FOO )AS FAK INNER JOIN lunchback_user_interested_user ON masterId = lunchback_user_interested_user.user_id,lunchback_user_profiles WHERE candidateId = target_id AND masterId = lunchback_user_profiles.id UNION SELECt DISTINCT h1.target_id as masterId , concat(p.first_name,' ',p.last_name) as masterName, p.headline, p.base_city as masterLocation, h1.user_id as candidateId FROM lunchback_view_history h1, lunchback_view_history h2,lunchback_user_profiles p WHERE h1.user_id = %d AND h2.user_id = h1.target_id AND h2.target_id = h1.user_id AND p.id = h1.target_id AND h1.user_id != h1.target_id") %(id,id,id)
	temp_list = []
	cursor.execute(query, id)
	for (masterId, masterName,headline,masterLocation,candidateId) in cursor:
		temp_list.append(masterId)
	target_list.append(temp_list)

for i in range(len(target_list)): t_list.append([idlist[i],target_list[i]])



def printeach(list,index=0):
    if index == 1:
        for i in range(len(list)):
            print("idx %d: %s" %(i, str(list[i])))
    else:
        for i in range(len(list)):
            print(list[i])

##############################################
for i in range(len(t_list)):
    for t in t_list[i][1]:
        if t not in idlist:
            t_list[i][1].remove(t)

for i in range(len(t_list)):
    for t in t_list[i][1]:
        if t not in idlist:
            t_list[i][1].remove(t)

for i in range(len(t_list)):
    for t in t_list[i][1]:
        if t not in idlist:
            t_list[i][1].remove(t)

for i in range(len(t_list)):
     if t_list[i][1] == []:
         left_over.append(t_list[i][0])

for i in range(len(t_list)):
     if t_list[i][0] in left_over:
         remove_list.append(t_list[i])

for list in remove_list:
     t_list.remove(list)


for i in range(len(t_list)):
    if len(t_list[i][1]) == 1:
        result_list.append([t_list[i][0],t_list[i][1][0]])
        rm_list_2.append(t_list[i][0])
        rm_list_2.append(t_list[i][1][0])


print("########idlist####")
print(idlist)
print "###############"


for rm in rm_list_2:
    for t in t_list:
        if t[0] == rm:
            t_list.remove(t)
############################################

for i in range(len(t_list)):
    idlist2.append(t_list[i][0])

for i in range(len(t_list)):
    for t in t_list[i][1]:
        if t not in idlist2:
            t_list[i][1].remove(t)

for i in range(len(t_list)):
    if len(t_list[i][1]) == 1:
            result_list.append([t_list[i][0], t_list[i][1][0]])
            rm_list_3.append(t_list[i][0])
            rm_list_3.append(t_list[i][1][0])

for rm in rm_list_3:
    for t in t_list:
        if t[0] == rm:
            t_list.remove(t)

#############################################
for i in range(len(t_list)):
    idlist3.append(t_list[i][0])

for i in range(len(t_list)):
    for t in t_list[i][1]:
        if t not in idlist3:
            t_list[i][1].remove(t)

for i in range(len(t_list)):
        if len(t_list[i][1]) == 1:
            result_list.append([t_list[i][0], t_list[i][1][0]])
            rm_list_4.append(t_list[i][0])
            rm_list_4.append(t_list[i][1][0])

for rm in rm_list_4 :
        for t in t_list:
            if t[0] == rm:
                t_list.remove(t)

##############################################
for i in range(len(t_list)):
    idlist4.append(t_list[i][0])

for i in range(len(t_list)):
    for t in t_list[i][1]:
        if t not in idlist4:
            t_list[i][1].remove(t)

for i in range(len(t_list)):
        if len(t_list[i][1]) == 1:
            result_list.append([t_list[i][0], t_list[i][1][0]])
            rm_list_5.append(t_list[i][0])
            rm_list_5.append(t_list[i][1][0])

for rm in rm_list_5 :
        for t in t_list:
            if t[0] == rm:
                t_list.remove(t)




# printeach(t_list)
# print left_over
print("########result_list######")
printeach(result_list)
print("----left_over-----")
printeach(left_over)
print("------T_list------")
printeach(t_list)
# print(len(t_list[7][1]))

cursor.close()
cnx.close()