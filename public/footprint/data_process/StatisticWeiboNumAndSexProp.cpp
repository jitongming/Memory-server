#include<iostream>
#include<fstream>
#include<string>
#include<map>

using namespace std;

map<string, int> my_map;

struct Area
{
    string name;
    int user_num,man,woman,vip;
    long weibo_num,fans_num,atten_num;
};

void ReadFile(Area *area,char *path,int count)
{
    ifstream fin(path);
    int i = 0,area_num;
    string sex,is_vip,address;
    int atten_num,fans_num,weibo_num;
    while(fin>>sex>>is_vip>>address)
    {
        count ++;
        area_num = my_map[address];
        if(sex == "m")
            area[area_num].man ++;
        else
            area[area_num].woman ++;
        if(is_vip == "TRUE")
            area[area_num].vip ++;

        fin>>atten_num>>fans_num>>weibo_num;

        area[area_num].atten_num += atten_num;
        area[area_num].fans_num += fans_num;
        area[area_num].weibo_num += weibo_num;
        area[area_num].user_num ++;
    }
    fin.close();
}

void WriteFile(Area *area,char *path)
{
    ofstream fout;
    fout.open(path,ios::trunc);
    fout<<"user_address,user_num,user_man,user_woman,weibo_num,fans_num,atten_num"<<endl;
    for(int i=0;i<36;i++)
    {
        fout<<area[i].name<<","<<area[i].user_num<<","<<area[i].man<<","<<area[i].woman<<","<<area[i].weibo_num<<","<<area[i].fans_num<<","<<area[i].atten_num<<endl;
    }
    fout.close();

}

int main()
{
    string state[36]={"�ӱ�","ɽ��","����","����","������","����","�㽭","����","����","����","ɽ��","����","����","����","�㶫","����","�Ĵ�","����","����","����","����","�ຣ","̨��","���ɹ�","����","����","����","�½�","���","����","����","���","����","�Ϻ�","����","����"};
    Area area[36];
    int i,count;
    count = 0;

    for(i=0;i<36;i++)
        my_map[state[i]] = i;

    for(i=0;i<36;i++)
    {
        area[i].name = state[i];
        area[i].user_num = 0;
        area[i].man = 0;
        area[i].woman = 0;
        area[i].vip = 0;
        area[i].weibo_num = 0;
        area[i].fans_num = 0;
        area[i].atten_num = 0;
    }

    ReadFile(area,"dataset_statistic.csv",count);
    WriteFile(area,"data_area_statistics.csv");

    return 0;
}
