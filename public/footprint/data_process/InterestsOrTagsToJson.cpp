#include<iostream>
#include<fstream>
#include<string>
#include<string.h>
#include<vector>
#include<map>

using namespace std;

map<string, int> mapProvince;
map<string, int> mapLabel;
vector<vector<int> > vectorInterest;
vector<vector<int> > vectorLabelCount;
vector<int> vectorTemp;
string state[34] = { "甘肃", "青海", "广西", "贵州", "重庆", "北京", "福建", "安徽", "广东", "西藏", "新疆", "海南", "宁夏", "陕西", "山西", "湖北", "湖南", "四川", "云南", "河北", "河南", "辽宁", "山东", "天津", "江西", "江苏", "上海", "浙江", "吉林", "内蒙古", "黑龙江", "香港", "澳门", "台湾" };


void ReadFile(char* path)
{
	map<string, int>::iterator it;
	ifstream fin(path);
	string str1, str2, strLine;
	string stringTemp;
	char charLabel[200];
	char *pch;
	int i, j;
	i = 0;
	j = 0;
	while (fin >> str1)
	{
		getline(fin, str2);

		strcpy(charLabel, str2.data());
		pch = strtok(charLabel, "\t\n, /");
		while (pch != NULL)
		{
			stringTemp = charLabel;
			it = mapLabel.find(stringTemp);
			if (it == mapLabel.end()) //if no label,new a label(in map)
			{
				mapLabel.insert(pair<string, int>(stringTemp, j));
				j++;
			}
			vectorInterest[mapProvince[str1]].push_back(mapLabel[stringTemp]); //store the label of province
			pch = strtok(NULL, "\t\n, /");
		}


	}

	fin.close();
	cout << "read file over" << endl;

}

void CountLabelProvince()
{
	int i, j;
	int labelValue;
	vectorLabelCount.resize(mapProvince.size());
	for (i = 0; i < vectorLabelCount.size(); i++)
	{
		vectorLabelCount[i].resize(mapLabel.size());
	}

	for (i = 0; i < vectorInterest.size(); i++)
	{
		for (j = 0; j < vectorInterest[i].size(); j++)
		{
			labelValue = vectorInterest[i][j];
			vectorLabelCount[i][labelValue] ++;
		}
	}
	cout << "count over"<<endl;
}

void WriteFile(char *path)
{
	map<string, int>::iterator it;
	map<string, int>::iterator it_label;
	ofstream fout;
	fout.open(path, ios::trunc);
	int i, j;
	int labelWeight;

	fout << "{\"features\":[";
	for (i = 0; i < 34; i++) //province
	{
		fout << "{";
		fout << "\"province\":";
		fout << "\"" << state[i] << "\",";

		j = 0;
		fout << "\"labels\":[";
		for (it_label = mapLabel.begin(); it_label != mapLabel.end(); it_label++)
		{
			labelWeight = vectorLabelCount[i][it_label->second];
			if (labelWeight == 0)
			{
				j++;
				continue;
			}
			fout << "{";
			fout << "\"label\":";
			fout << "\"" << it_label->first << "\",";
			fout << "\"weight\":";
			fout << labelWeight;
			fout << "}";
			if (j != mapLabel.size() - 1)
			{
				fout << ",";
			}
			j++;
		}
		fout << "]";

		fout << "}";
		if (i != 34 - 1)
		{
			fout << ",";
		}
	}
	fout << "]}";


	fout.close();
	cout << "write file over" << endl;

}

int main()
{
	int i;
	for (i = 0; i < 34; i++)
		mapProvince.insert(pair<string, int>(state[i], i));
	vectorTemp.clear();
	for (i = 0; i < 34; i++)
	{
		vectorInterest.push_back(vectorTemp);
	}

	char readPath[200], writePath[200];
	cout << "Input read file name : ";
	cin >> readPath;
	cout << "Input write file name : ";
	cin >> writePath;

	ReadFile(readPath);

	CountLabelProvince();

	WriteFile(writePath);


	return 0;
}
