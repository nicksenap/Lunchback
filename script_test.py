# -*- coding: utf-8 -*-

from mysql.connector import (connection)
from tqdm import *

cnx = connection.MySQLConnection(user='lunchback', password='',
                              host='127.0.0.1',
                              database='vssf_core')
cursor = cnx.cursor()

# idlist_bak = [int(x) for x in input("> User ids: ").split()]

magic_id_file = open('magic_ids.txt', 'r')
had_lunch_before = open('had_lunch_before.txt', 'r')
lunched_before_raw = [had_lunch_before.readlines()][0]
lunched_before = []
for lunched in lunched_before_raw:
	lunched_before.append([int(lunched.split(',')[0]),int(lunched.split(',')[1])])
idlist = map(int,[magic_id_file.readlines()][0])

# idlist = map(int,[line.split(',') for line in magic_id_file.readlines()][0])
# idlist = [660,106,1911,1485,592,1592,73,972,753,335,904,113,656,1369,637,578,376,2122,66,2226,75,2207]
# idlist = range(1011)

# ----- Lists ----- #
target_list = []
left_over_list = []
two_list = []
anti_duplicate_list = []
premiere_id = []
result_list = []
check_list = []
lo = []


# ----- Fetch info from database -----#
def fetch_info():
	for id in tqdm(idlist):
		query = ("SELECT masterId, concat(lunchback_user_profiles.first_name,' ',lunchback_user_profiles.last_name) as masterName, lunchback_user_profiles.headline, lunchback_user_profiles.base_city as masterLocation ,candidateId FROM ( SELECT masterId,candidateId FROM ( SELECT DISTINCT t1.user_id as masterId, concat(p1.first_name,' ',p1.last_name) as masterName, p1.headline,p2.id as candidateId FROM lunchback_user_tags t1 JOIN lunchback_user_tags t2, lunchback_user_profiles p1 JOIN lunchback_user_profiles p2 WHERE t2.user_id = %d AND t1.user_id != t2.user_id AND t1.tag_type = 'offering' AND t2.tag_type = 'searching' AND t1.tag = t2.tag AND p1.id = t1.user_id AND p2.id = t2.user_id AND t2.tag = t1.tag AND p1.base_city = p2.base_city AND p1.removed = 0 AND p2.removed = 0 AND t1.removed = 0 AND t2.removed = 0 UNION SELECt DISTINCT h1.target_id as masterId , concat(p.first_name,' ',p.last_name) as masterName, p.headline,h1.user_id as candidateId FROM lunchback_view_history h1, lunchback_view_history h2,lunchback_user_profiles p WHERE h1.user_id = %d AND h2.user_id = h1.target_id AND h2.target_id = h1.user_id AND p.id = h1.target_id) AS FOO )AS FAK INNER JOIN lunchback_user_interested_user ON masterId = lunchback_user_interested_user.user_id,lunchback_user_profiles WHERE candidateId = target_id AND masterId = lunchback_user_profiles.id UNION SELECt DISTINCT h1.target_id as masterId , concat(p.first_name,' ',p.last_name) as masterName, p.headline, p.base_city as masterLocation, h1.user_id as candidateId FROM lunchback_view_history h1, lunchback_view_history h2,lunchback_user_profiles p WHERE h1.user_id = %d AND h2.user_id = h1.target_id AND h2.target_id = h1.user_id AND p.id = h1.target_id AND h1.user_id != h1.target_id") %(id,id,id)
		temp_list = []
		cursor.execute(query, id)
		temp_list.append(id)
		for (masterId, masterName,headline,masterLocation,candidateId) in cursor:
			if masterId in idlist:
				temp_list.append(masterId)
			else:
				pass
		target_list.append(temp_list)
	return target_list


def printeach(list,index=0):
    if index == 1:
        for i in range(len(list)):
            print("idx %d: %s" %(i, str(list[i])))
    else:
        for i in range(len(list)):
            print(list[i])


# ----- Pick out lists that do have a match ----- #
def pick_left_over(target_list):
	return [lst for lst in target_list if not len(lst) == 1]
	

# ----- Pick out the leftovers ----- #
def left_over(target_list, somelist):
	return [a[0] for a in target_list+somelist if (a not in target_list) or (a not in somelist)]

def left_over_two(target_list, somelist):
	return [a for a in target_list+somelist if (a not in target_list) or (a not in somelist)]


# ----- Cut the lists to 2 elments lists ----- #
def x_to_two(x_list):
	for x in x_list:
		if len(x) == 2:
			two_list.append(x)
		else:
			for i in range(1,len(x)):
				two_list.append([x[0],x[i]])
	return two_list

def havent_lunched(two_list,lunched_before):
	return [two for two in two_list if not two in lunched_before]

# ----- anti duplicate ----- #
def anti_duplicate(duplicate_list):
	for lst in duplicate_list:
		if lst[::-1] in duplicate_list:
			anti_duplicate_list.append(lst)
			duplicate_list.remove(lst[::-1])
	return anti_duplicate_list


# ----- produce a list of all the id left in premiere result ----- #
def pruning_helper(premiere_list):
	for lst in premiere_list:
		for ls in lst:
			if ls not in premiere_id:
				premiere_id.append(ls)
			else:
				pass
	return premiere_id


def pruning(premiere_list, premiere_id, left_over_list):
	for lst in premiere_list:
		if lst[0] in premiere_id and lst[1] in premiere_id:
			result_list.append(lst)
			premiere_id.remove(lst[0])
			premiere_id.remove(lst[1])
		else:
			pass
	for ld in premiere_id:
		left_over_list.append(ld)

	# print(left_over_list)
	return result_list


def main():
	longstring = """\
                        _                      _       _   
                       (_)                    (_)     | |  
  _ __ ___   __ _  __ _ _  ___   ___  ___ _ __ _ _ __ | |_ 
 | '_ ` _ \ / _` |/ _` | |/ __| / __|/ __| '__| | '_ \| __|
 | | | | | | (_| | (_| | | (__  \__ \ (__| |  | | |_) | |_ 
 |_| |_| |_|\__,_|\__, |_|\___| |___/\___|_|  |_| .__/ \__|
                   __/ |                        | |        
                  |___/                         |_|  
"""
	print('==================================================================')
	print(longstring)
	print('==================================================================')
	print('Initializing.....')
	

	target_list = fetch_info()
	x_list = pick_left_over(target_list)
	
	two_list = x_to_two(x_list)
	
	# two_list_havent_lunched = havent_lunched(two_list, lunched_before)
	# diff = left_over_two(two_list, two_list_havent_lunched)
	
	# for di in diff:
	#	for d in di:
	#		if d not in left_over_list:
	#			left_over_list.append(d)
	#		else:
	#			pass
	
	
	# pr_res = anti_duplicate(two_list_havent_lunched)
	
	pr_res = anti_duplicate(two_list)
	pr_id = pruning_helper(pr_res)
	res = pruning(pr_res,pr_id,left_over_list)
	check_list = [item for sublist in res for item in sublist]
	lo = list(set(idlist) - set(check_list))



	flag = True
	while flag:
		choose = raw_input('Data fetched, Do you want amount of matches or the full result? (A/F) or Q for Quit: ')
		if choose.upper() == 'A':
			print('====================')
			print('Premiere result (Pairs): ')
			print('====================')
			print(len(res))
			print('====================')
			print('Left over:')
			print('====================')
			print(len(lo))
		elif choose.upper() == 'F':
			print('====================')
			print('Premiere result:')
			print('====================')
			printeach(res)
			print('====================')
			print('Left over:')
			print('====================')
			printeach(lo)
			# printeach(left_over_list)
		elif choose.upper() == 'Q':
			flag = False
		else:
			print('Wrong input, Plesae try again:  ')
	
	# printeach(anti_duplicate(x_to_two(x_list)))
	

def printid():
	print(lunched_before)


main()
# printid()


cursor.close()
cnx.close()